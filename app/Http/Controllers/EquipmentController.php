<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use QrCode;
use DB;

class EquipmentController extends Controller
{
    public function manage()
    {
        $equipments = DB::table('equipments')
        ->join('categories','categories.cat_id','=','equipments.cat_id')
        // ->where('eqp_active','=','1')
        ->orderBy('equipments.eqp_name','ASC')
        ->get();

        $categories = DB::table('categories')
        ->where('cat_active','=','1')
        ->orderBy('cat_name','ASC')
        ->get();

        return view('admin.equipment.manage',compact('equipments','categories'));
    }

    public function save(Request $request)
    {
        $eqp_name = $request->eqp_name;
        $eqp_description = $request->eqp_description;
        $eqp_quantity = $request->eqp_quantity;
        $eqp_date_acquired = $request->eqp_date_acquired;
        $eqp_manufacturer = $request->eqp_manufacturer;
        $cat_id = $request->cat_id;

        $equipment = DB::table('equipments')
        ->where('eqp_name','=',$eqp_name)
        ->first();

        if($equipment){
            alert()->error('An equipment with the same name ' . $eqp_name . ' already exists.');
        }else{
            DB::table('equipments')
            ->insert([
                'eqp_uuid' => generateuuid(),
                'eqp_name' => $eqp_name,
                'eqp_description' => $eqp_description,
                'eqp_quantity' => $eqp_quantity,
                'eqp_manufacturer' => $eqp_manufacturer,
                'eqp_date_acquired' => $eqp_date_acquired,
                'cat_id' => $cat_id,
                'eqp_date_created' => Carbon::now(),
                'eqp_created_by' => session('usr_id')
            ]);
    
            alert()->info('New equipment has been added.');
        }

        return redirect()->action([EquipmentController::class, 'manage']);
    }

    public function update(Request $request)
    {
        $eqp_name = $request->eqp_name;
        $eqp_description = $request->eqp_description;
        $eqp_quantity = $request->eqp_quantity;
        $eqp_uuid = $request->eqp_uuid;
        $eqp_date_acquired = $request->eqp_date_acquired;
        $eqp_manufacturer = $request->eqp_manufacturer;
        $cat_id = $request->cat_id;

        DB::table('equipments')
        ->where('eqp_uuid','=',$eqp_uuid)
        ->update([
            'eqp_name' => $eqp_name,
            'eqp_description' => $eqp_description,
            'eqp_quantity' => $eqp_quantity,
            'eqp_manufacturer' => $eqp_manufacturer,
            'eqp_date_acquired' => $eqp_date_acquired,
            'cat_id' => $cat_id,
            'eqp_date_modified' => Carbon::now(),
            'eqp_modified_by' => session('usr_id')
        ]);

        alert()->info('Equipment has been updated.');
        return redirect()->action([EquipmentController::class, 'manage']);
    }

    public function activate($eqp_uuid)
    {
        DB::table('equipments')
        ->where('eqp_uuid','=',$eqp_uuid)
        ->update([
            'eqp_active' => '1'
        ]);

        alert()->success('Success','Equipment has been activated.');
        return redirect()->back();
    }

    public function deactivate($eqp_uuid)
    {
        DB::table('equipments')
        ->where('eqp_uuid','=',$eqp_uuid)
        ->update([
            'eqp_active' => '0'
        ]);

        alert()->success('Success','Equipment has been deactivated.');
        return redirect()->back();
    }
}
