<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use QrCode;
use DB;

class BorrowController extends Controller
{
    public function main()
    {
        $equipments = DB::table('equipments')
        ->where('eqp_active','=','1')
        ->orderBy('eqp_name','ASC')
        ->get();

        return view('admin.borrow.main',compact('equipments'));
    }

    public function borrow(Request $request)
    {
        $eqp_id = $request->eqp_id;
        $eqp_quantity2 = $request->eqp_quantity2;

        DB::table('borrow_requests')
        ->insert([
            'res_uuid' => generateuuid(),
            'eqp_id' => $eqp_id,
            'res_quantity' => $eqp_quantity2,
            'bor_id' => session('usr_id'),
            'res_date_requested' => Carbon::now(),
            'res_status' => '1', //1=for_approval,2=released,3=returned,-1=disapproved
            'res_active' => '1'
        ]);

        DB::table('equipments')
        ->where('eqp_id','=',$eqp_id)
        ->decrement('eqp_quantity', $eqp_quantity2);

        alert()->info('Equipment has been reserved pending approval. Proceed to checkout counter for releasing.');
        return redirect()->action([BorrowController::class, 'history']);
    }

    public function history()
    {
        $borrow_requests = DB::table('borrow_requests')
        ->join('borrowers','borrowers.bor_id','=','borrow_requests.bor_id')
        ->join('equipments','equipments.eqp_id','=','borrow_requests.eqp_id')
        ->where('borrow_requests.bor_id','=',session('usr_id'))
        ->orderBy('borrow_requests.res_date_requested','DESC')
        ->get();

        return view('admin.borrow.history',compact('borrow_requests'));
    }

    public function overdue()
    {
        $borrow_requests_loop = DB::table('borrow_requests')
        ->join('equipments','equipments.eqp_id','=','borrow_requests.eqp_id')
        ->where('borrow_requests.res_status','=','2')
        ->where('borrow_requests.bor_id','=',session('usr_id'))
        ->where('borrow_requests.res_active','=','1')
        ->get();

        $overdue_ids = array();

        foreach($borrow_requests_loop as $borrow_request)
        {
            $date1 = new DateTime(today());
            $date2 = new DateTime($borrow_request->res_date_to_return);

            if($date1 > $date2){
                array_push($overdue_ids, $borrow_request->res_id);
            }
        }

        $borrow_requests = DB::table('borrow_requests')
        ->join('borrowers','borrowers.bor_id','=','borrow_requests.bor_id')
        ->join('equipments','equipments.eqp_id','=','borrow_requests.eqp_id')
        ->whereIn('borrow_requests.res_id',[$overdue_ids])
        ->get();

        return view('admin.borrow.history',compact('borrow_requests'));
    }

    public function requests()
    {
        $borrow_requests = DB::table('borrow_requests')
        ->join('borrowers','borrowers.bor_id','=','borrow_requests.bor_id')
        ->join('equipments','equipments.eqp_id','=','borrow_requests.eqp_id')
        ->where('borrow_requests.res_status','=','1')
        ->where('borrow_requests.res_active','=','1')
        ->orderBy('borrow_requests.res_date_requested','DESC')
        ->get();

        return view('admin.borrow.requests',compact('borrow_requests'));
    }

    public function unreturned()
    {
        $borrow_requests = DB::table('borrow_requests')
        ->join('borrowers','borrowers.bor_id','=','borrow_requests.bor_id')
        ->join('equipments','equipments.eqp_id','=','borrow_requests.eqp_id')
        ->where('borrow_requests.res_status','=','2')
        ->where('borrow_requests.res_active','=','1')
        ->orderBy('borrow_requests.res_date_requested','DESC')
        ->get();

        return view('admin.borrow.unreturned',compact('borrow_requests'));
    }

    public function approve($res_uuid)
    {
        $borrow_request = DB::table('borrow_requests')
        ->join('equipments','equipments.eqp_id','borrow_requests.eqp_id')
        ->where('borrow_requests.res_uuid','=',$res_uuid)
        ->first();

        DB::table('borrow_requests')
        ->where('res_uuid','=',$res_uuid)
        ->update([
            'res_approved_by' => session('usr_id'),
            'res_date_released' => Carbon::now(),
            'res_date_to_return' => return_on(Carbon::today(),$borrow_request->eqp_borrow_days),
            'res_status' => '2' //1=for_approval,2=released,3=returned,-1=disapproved
        ]);

        alert()->info('Equipment request has been approved and released to borrower.');
        return redirect()->action([BorrowController::class, 'requests']);
    }

    public function disapprove($res_uuid)
    {
        DB::table('borrow_requests')
        ->where('res_uuid','=',$res_uuid)
        ->update([
            'res_approved_by' => session('usr_id'),
            'res_date_released' => Carbon::now(),
            'res_status' => '-1' //1=for_approval,2=released,3=returned,-1=disapproved
        ]);

        $borrow_request = DB::table('borrow_requests')
        ->where('res_uuid','=',$res_uuid)
        ->first();

        DB::table('equipments')
        ->where('eqp_id','=',$borrow_request->eqp_id)
        ->increment('eqp_quantity', $borrow_request->res_quantity);

        alert()->info('Equipment request has been disapproved.');
        return redirect()->action([BorrowController::class, 'requests']);
    }

    public function return($res_uuid)
    {
        DB::table('borrow_requests')
        ->where('res_uuid','=',$res_uuid)
        ->update([
            'res_return_received_by' => session('usr_id'),
            'res_date_returned' => Carbon::now(),
            'res_status' => '3' //1=for_approval,2=released,3=returned,-1=disapproved
        ]);

        $borrow_request = DB::table('borrow_requests')
        ->where('res_uuid','=',$res_uuid)
        ->first();

        DB::table('equipments')
        ->where('eqp_id','=',$borrow_request->eqp_id)
        ->increment('eqp_quantity', $borrow_request->res_quantity);

        alert()->info('Equipment request has been returned.');
        return redirect()->action([BorrowController::class, 'requests']);
    }

    public function historyAll()
    {
        $borrow_requests = DB::table('borrow_requests')
        ->join('borrowers','borrowers.bor_id','=','borrow_requests.bor_id')
        ->join('equipments','equipments.eqp_id','=','borrow_requests.eqp_id')
        ->orderBy('borrow_requests.res_date_requested','DESC')
        ->get();

        return view('admin.borrow.history',compact('borrow_requests'));
    }

    public function search()
    {
        return view('admin.borrow.search');
    }

    public function find(Request $request)
    {
        $borrow_request = DB::table('borrow_requests')
        ->join('equipments','equipments.eqp_id','=','borrow_requests.eqp_id')
        ->where('borrow_requests.res_uuid','=',$request->res_uuid)
        ->first();

        if($borrow_request){
            return view('admin.borrow.details',compact('borrow_request'));
        }else{
            alert()->error('Invalid QR Code','Transaction details not found.');
            return redirect()->back();
        }
    }
}
