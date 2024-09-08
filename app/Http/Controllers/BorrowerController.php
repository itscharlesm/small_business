<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use QrCode;
use DB;

class BorrowerController extends Controller
{
    public function manage()
    {
        $borrowers = DB::table('borrowers')
        ->orderBy('bor_last_name','ASC')
        ->orderBy('bor_first_name','ASC')
        ->get();

        return view('admin.borrowers.manage',compact('borrowers'));
    }

    public function save(Request $request)
    {
        $bor_last_name = $request->bor_last_name;
        $bor_first_name = $request->bor_first_name;
        $bor_middle_name = $request->bor_middle_name;
        $bor_address = $request->bor_address;
        $bor_mobile = $request->bor_mobile;
        $bor_email = $request->bor_email;
        $bor_student_id = $request->bor_student_id;
        $code = generateDigitCode();

        DB::table('borrowers')
        ->insert([
            'bor_uuid' => generateuuid(),
            'bor_code' => $code,
            'bor_password' => md5($code),
            'bor_last_name' => $bor_last_name,
            'bor_first_name' => $bor_first_name,
            'bor_middle_name' => $bor_middle_name,
            'bor_address' => $bor_address,
            'bor_mobile' => $bor_mobile,
            'bor_email' => $bor_email,
            'bor_student_id' => $bor_student_id,
            'bor_created_by' => session('usr_id'),
            'bor_date_created' => Carbon::now(),
            'bor_active' => '1'
        ]);

        $emailSubject = 'Infinit SMS new borrower';
        $emailContent = 'Please use the following as your username: [' . $bor_email . '] and passsword: [' . $code . '].';
        $emailTo = $bor_email;

        sendEmail($emailSubject,$emailContent,$emailTo);

        alert()->info('New borrower has been added. Temporary password has been sent via SMS and E-mail.');
        return redirect()->action([BorrowerController::class, 'manage']);
    }

    public function update(Request $request)
    {
        $bor_uuid = $request->bor_uuid;
        $bor_last_name = $request->bor_last_name;
        $bor_first_name = $request->bor_first_name;
        $bor_middle_name = $request->bor_middle_name;
        $bor_address = $request->bor_address;
        $bor_mobile = $request->bor_mobile;
        $bor_email = $request->bor_email;
        $bor_student_id = $request->bor_student_id;
        $code = generateDigitCode();

        DB::table('borrowers')
        ->where('bor_uuid','=',$bor_uuid)
        ->update([
            'bor_last_name' => $bor_last_name,
            'bor_first_name' => $bor_first_name,
            'bor_middle_name' => $bor_middle_name,
            'bor_address' => $bor_address,
            'bor_mobile' => $bor_mobile,
            'bor_email' => $bor_email,
            'bor_student_id' => $bor_student_id,
            'bor_modified_by' => session('usr_id'),
            'bor_date_modified' => Carbon::now()
        ]);

        alert()->info('Borrower has been updated.');
        return redirect()->action([BorrowerController::class, 'manage']);
    }

    public function activate($bor_uuid)
    {
        DB::table('borrowers')
        ->where('bor_uuid','=',$bor_uuid)
        ->update([
            'bor_active' => '1'
        ]);

        alert()->success('Success','Borrower has been activated.');
        return redirect()->back();
    }

    public function deactivate($bor_uuid)
    {
        DB::table('borrowers')
        ->where('bor_uuid','=',$bor_uuid)
        ->update([
            'bor_active' => '0'
        ]);

        alert()->success('Success','Borrower has been deactivated.');
        return redirect()->back();
    }

    public function reset($bor_uuid)
    {
        $code = generateDigitCode();

        $borrower = DB::table('borrowers')
        ->where('bor_uuid','=',$bor_uuid)
        ->first();

        $bor_email = $borrower->bor_email;

        DB::table('borrowers')
        ->where('bor_uuid', '=', $bor_uuid)
        ->update([
            'bor_password' => md5($code),
            'bor_code' => $code
        ]);

        $emailSubject = 'Infinit SMS password reset';
        $emailContent = 'An administrator has reset your password. Your new password is ' . $code . '.';
        $emailTo = $bor_email;

        sendEmail($emailSubject,$emailContent,$emailTo);

        alert()->info('Password has been reset','A new password has been generated and sent to ' . $bor_email . '.');
        return redirect()->action([BorrowerController::class, 'manage']);
    }
}
