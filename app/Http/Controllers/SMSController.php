<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SMSController extends Controller
{
    public function composeIndividual()
    {
        $contacts = DB::table('contacts')
        ->where('acc_id', '=', session('acc_id'))
        ->where('con_active','=','1')
        ->orderby('con_name')
        ->get();

        return view('admin.sms.composeIndividual',compact('contacts'));
    }

    public function composeCategory()
    {
        $categories = DB::table('categories')
        ->where('acc_id', '=', session('acc_id'))
        ->where('cat_active','=','1')
        ->orderby('cat_name')
        ->get();

        return view('admin.sms.composeCategory',compact('categories'));
    }

    public function sendIndividual(Request $request)
    {
        $con_ids = $request->con_ids;
        $sms_content = $request->sms_content;

        $contacts = DB::table('contacts')
        ->whereIn('con_id',$con_ids)
        ->select('con_mobile','con_id')
        ->get();

        $data = [];
        $data2 = [];

        $credits = get_remaining_daily_credits();
        $used_credits = 0;

        foreach($contacts as $contact)
        {
            if($credits > 0){
                $data[] = [
                    'sms_number' => $contact->con_mobile,
                    'sms_content' => session('acc_short_name') . ': ' . $sms_content,
                    'sms_priority' => '1',
                    'sms_created_by' => session('usr_id'),
                    'sms_date_created' => \Carbon\Carbon::now(),
                ];
    
                $data2[] = [
                    'acc_id' => session('acc_id'),
                    'con_id' => $contact->con_id,
                    'sms_number' => $contact->con_mobile,
                    'sms_content' => session('acc_short_name') . ': ' . $sms_content,
                    'sms_created_by' => session('usr_id'),
                    'sms_date_created' => \Carbon\Carbon::now(),
                ];

                $used_credits += 1;
                $credits -= 1;
            }
        }

        increment_daily_credit_counter($used_credits);

        DB::table('sms')
        ->insert($data2);

        DB::connection('sms')
        ->table('sms_queue')
        ->insert($data);

        alert()->success('Bulk SMS has been queued to server for processing.');
        return redirect()->action([SMSController::class, 'composeIndividual']);
    }

    public function sendCategory(Request $request)
    {
        $cat_ids = $request->cat_ids;
        $sms_content = $request->sms_content;

        $contacts = DB::table('contacts')
        ->join('contact_categories','contact_categories.con_id','=','contacts.con_id')
        ->whereIn('contact_categories.cat_id',$cat_ids)
        ->groupby('contacts.con_mobile')
        ->select('contacts.con_mobile','contacts.con_id')
        ->get();

        $data = [];
        $data2 = [];

        $credits = get_remaining_daily_credits();
        $used_credits = 0;

        foreach($contacts as $contact)
        {
            if($credits > 0){
                $data[] = [
                    'sms_number' => $contact->con_mobile,
                    'sms_content' => session('acc_short_name') . ': ' . $sms_content,
                    'sms_priority' => '1',
                    'sms_created_by' => session('usr_id'),
                    'sms_date_created' => \Carbon\Carbon::now(),
                ];

                $data2[] = [
                    'acc_id' => session('acc_id'),
                    'con_id' => $contact->con_id,
                    'sms_number' => $contact->con_mobile,
                    'sms_content' => session('acc_short_name') . ': ' . $sms_content,
                    'sms_created_by' => session('usr_id'),
                    'sms_date_created' => \Carbon\Carbon::now(),
                ];

                $used_credits += 1;
                $credits -= 1;
            }
        }

        increment_daily_credit_counter($used_credits);
        
        DB::table('sms')
        ->insert($data2);

        DB::connection('sms')
        ->table('sms_queue')
        ->insert($data);

        alert()->success('Bulk SMS has been queued to server for processing.');
        return redirect()->action([SMSController::class, 'composeCategory']);
    }

    public function history()
    {
        $messages = DB::table('sms')
        ->join('contacts','contacts.con_id','=','sms.con_id')
        ->select('sms.sms_date_created','sms.sms_number','sms.sms_content','contacts.con_name')
        ->where('sms.acc_id', '=', session('acc_id'))
        ->orderby('sms.sms_date_created','desc')
        ->limit('100')
        ->get();

        return view('admin.sms.history',compact('messages'));
    }

    public function history2(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $messages = DB::table('sms')
        ->join('contacts','contacts.con_id','=','sms.con_id')
        ->select('sms.sms_date_created','sms.sms_number','sms.sms_content','contacts.con_name')
        ->where('sms.acc_id', '=', session('acc_id'))
        ->whereDate('sms.sms_date_created', '>=', $date_from)
        ->whereDate('sms.sms_date_created', '<=', $date_to)
        ->orderby('sms.sms_date_created','desc')
        ->get();

        return view('admin.sms.history',compact('messages','date_from','date_to'));
    }
}
