<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function main()
    {
        return view('admin.dashboard.main');
    }

    public function search(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $top_10_equipments = DB::table('borrow_requests')
        ->select(
            'equipments.eqp_name',
            DB::raw('SUM(borrow_requests.res_quantity) as total')
        )
        ->join('equipments', 'equipments.eqp_id', '=', 'borrow_requests.eqp_id')
        ->whereDate('borrow_requests.res_date_requested','>=',$from_date)
        ->whereDate('borrow_requests.res_date_requested','<=',$to_date)
        ->whereIn('borrow_requests.res_status',['2','3'])
        ->where('borrow_requests.res_active','=','1')
        ->groupBy('borrow_requests.eqp_id')
        ->limit(10)
        ->get();

        foreach($top_10_equipments as $indexKey=>$top_equipment)
        {
            $data["labels"][$indexKey] = $top_equipment->eqp_name;
            $data["data"][$indexKey] = $top_equipment->total;
        }

        $top_equipments = DB::table('borrow_requests')
        ->select(
            'equipments.eqp_name',
            DB::raw('SUM(borrow_requests.res_quantity) as total')
        )
        ->join('equipments', 'equipments.eqp_id', '=', 'borrow_requests.eqp_id')
        ->whereDate('borrow_requests.res_date_requested','>=',$from_date)
        ->whereDate('borrow_requests.res_date_requested','<=',$to_date)
        ->whereIn('borrow_requests.res_status',['2','3'])
        ->where('borrow_requests.res_active','=','1')
        ->groupBy('borrow_requests.eqp_id')
        ->orderby('total','desc')
        ->get();


        $top_10_borrowers = DB::table('borrow_requests')
        ->select(
            'borrowers.bor_last_name',
            'borrowers.bor_first_name',
            'borrowers.bor_middle_name',
            DB::raw('SUM(borrow_requests.res_quantity) as total')
        )
        ->join('borrowers', 'borrowers.bor_id', '=', 'borrow_requests.bor_id')
        ->whereDate('borrow_requests.res_date_requested','>=',$from_date)
        ->whereDate('borrow_requests.res_date_requested','<=',$to_date)
        ->whereIn('borrow_requests.res_status',['2','3'])
        ->where('borrow_requests.res_active','=','1')
        ->groupBy('borrow_requests.bor_id')
        ->limit(10)
        ->get();

        foreach($top_10_borrowers as $indexKey=>$top_10_borrower)
        {
            $data2["labels"][$indexKey] = $top_10_borrower->bor_last_name . ', ' . $top_10_borrower->bor_first_name . ' ' . $top_10_borrower->bor_middle_name;
            $data2["data"][$indexKey] = $top_10_borrower->total;
        }

        $top_borrowers = DB::table('borrow_requests')
        ->select(
            'borrowers.bor_last_name',
            'borrowers.bor_first_name',
            'borrowers.bor_middle_name',
            DB::raw('SUM(borrow_requests.res_quantity) as total')
        )
        ->join('borrowers', 'borrowers.bor_id', '=', 'borrow_requests.bor_id')
        ->whereDate('borrow_requests.res_date_requested','>=',$from_date)
        ->whereDate('borrow_requests.res_date_requested','<=',$to_date)
        ->whereIn('borrow_requests.res_status',['2','3'])
        ->where('borrow_requests.res_active','=','1')
        ->groupBy('borrow_requests.bor_id')
        ->orderby('total','desc')
        ->get();

        return view('admin.dashboard.main',compact('top_equipments','top_borrowers','data','data2','from_date','to_date'));
    }
}
