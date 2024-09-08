<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function gmc(){
        return redirect()->to('http://crms.umin.edu.ph/gmc/');
    }

    public function sps(){
        return redirect()->to('http://crms.umin.edu.ph/sps/public/');
    }
}
