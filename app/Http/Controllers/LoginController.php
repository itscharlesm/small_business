<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function validateUser(Request $request)
    {

        $usr_email = $request->email;
        $usr_password = $request->password;

        $user = DB::table('users')
            ->where('usr_email', '=', $usr_email)
            ->where('users.usr_password', '=', md5($usr_password))
            // ->where('users.usr_code', '=', ($usr_password))
            ->where('usr_active', '=', '1')
            ->first();

        if ($user) {
            setUserSessionVariables($user);
            return redirect()->action([AdminController::class, 'home']);
        } else {
            alert()->error('Invalid Credentials', 'Invalid e-mail or password');
            return redirect()->back();
        }
    }

    // public function loginAccount(Request $request)
    // {
    //     // $this->validate($request, [
    //     //     'g-recaptcha-response' => 'required|captcha',
    //     // ]);

    //     $usr_email = $request->email;
    //     $usr_password = $request->password;
    //     $acc_id = $request->acc_id;
    //     $mode = $request->mode;

    //     $user = DB::table('users')
    //     ->join('accounts','accounts.acc_id','=','users.acc_id')
    //     ->where('users.usr_email', '=', $usr_email)
    //     ->where('users.usr_active', '=', '1')
    //     ->where('accounts.acc_active', '=', '1')
    //     ->first();

    //     if($mode == 'admin'){
    //         if($user) {
    //             if($user->usr_invalid_login_count >= 5){
    //                 alert()->error('Account Locked','Too many failed login attempts. Please use the "Forgot Password" to reset your account.');
    //                 return redirect()->action([MainController::class, 'mainAdmin'], ['acc_id' => $acc_id]);
    //             }else{
    //                 if($user->usr_password == md5($usr_password)){
    //                     resetUserLoginCounter($usr_email);
    //                     setUserSessionVariables($user,$mode);
    //                     return redirect()->action([AdminController::class, 'home']);
    //                 }else{
    //                     incrementUserLoginCounter($usr_email);
    //                     alert()->error('Invalid Credentials','Invalid e-mail or password');
    //                     return redirect()->action([MainController::class, 'mainAdmin'], ['acc_id' => $acc_id]);
    //                 }
    //             }
    //         } else {
    //             alert()->error('Invalid Credentials','Invalid e-mail or password');
    //             return redirect()->action([MainController::class, 'mainAdmin'], ['acc_id' => $acc_id]);
    //         }
    //     }else{
    //         $borrower = DB::table('borrowers')
    //         ->where('bor_email', '=', $usr_email)
    //         ->where('bor_password', '=', md5($usr_password))
    //         ->where('bor_active', '=', '1')
    //         ->first();

    //         if($borrower){
    //             setUserSessionVariables($borrower,$mode);
    //             return redirect()->action([AdminController::class, 'home']);
    //         }else{
    //             alert()->error('Invalid Credentials','Invalid e-mail or password');
    //             return redirect()->action([MainController::class, 'mainBorrower'], ['acc_id' => $acc_id]);
    //         }
    //     }
    // }

    public function forgotPassword()
    {

    }

    public function logout()
    {
        session()->flush();
        return redirect()->action([MainController::class, 'main']);
    }
}
