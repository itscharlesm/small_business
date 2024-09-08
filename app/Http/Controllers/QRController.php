<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;
use DB;

class QRController extends Controller
{
    public function generate($qrdata)
    {
        $qrdata = QrCode::size(300)->generate($qrdata);
        return view('admin.qr.main',compact('qrdata'));
    }
}
