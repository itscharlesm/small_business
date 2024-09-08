<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ContactController extends Controller
{
    public function manage()
    {
        $categories = DB::table('categories')
        ->where('acc_id', '=', session('acc_id'))
        ->where('cat_active', '=', '1')
        ->orderBy('cat_name')
        ->get();

        return view('admin.contacts.manage',compact('categories'));
    }

    public function find(Request $request)
    {
        $search_string = $request->search_string;

        $contacts = DB::table('contacts')
        ->where('acc_id', '=', session('acc_id'))
        ->where('con_name', 'LIKE', $search_string . '%')
        ->where('con_active', '=', '1')
        ->orderBy('con_name','ASC')
        ->get();

        $categories = DB::table('categories')
        ->where('acc_id', '=', session('acc_id'))
        ->where('cat_active', '=', '1')
        ->orderBy('cat_name')
        ->get();

        return view('admin.contacts.manage',compact('categories','search_string','contacts'));
    }

    public function save(Request $request)
    {
        $con_mobile = $request->con_mobile;
        $con_name = $request->con_name;
        $categories = $request->categories;

        $contact = DB::table('contacts')
        ->where('con_mobile','=',$con_mobile)
        ->where('acc_id','=',session('acc_id'))
        ->first();

        if($contact){
            alert()->error('A contact with mobile number ' . $con_mobile . ' already exists in the system.');
        }else{
            $con_id = DB::table('contacts')
            ->insertGetId([
                'con_uuid' => generateuuid(),
                'acc_id' => session('acc_id'),
                'con_name' => $con_name,
                'con_mobile' => (int)$con_mobile,
                'con_date_created' => Carbon::now(),
                'con_created_by' => session('usr_id'),
                'con_active' => '1'
            ]);
            
            if($categories){
                foreach($categories as $cat_id)
                {
                    DB::table('contact_categories')
                    ->insert([
                        'con_id' => $con_id,
                        'cat_id' => $cat_id
                    ]);
                }
            }
           
            alert()->success('Contact has been created.');
        }

        return redirect()->action([ContactController::class, 'manage']);
    }

    public function update(Request $request)
    {
        $con_mobile = $request->con_mobile;
        $con_name = $request->con_name;
        $categories = $request->categories;
        $con_id = $request->con_id;

        DB::table('contacts')
        ->where('con_id','=',$con_id)
        ->update([
            'con_name' => $con_name,
            'con_mobile' => (int)$con_mobile,
            'con_date_modified' => Carbon::now(),
            'con_modified_by' => session('usr_id'),
            'con_active' => '1'
        ]);

        DB::table('contact_categories')
        ->where('con_id','=',$con_id)
        ->delete();
        
        if($categories){
            foreach($categories as $cat_id)
            {
                DB::table('contact_categories')
                ->insert([
                    'con_id' => $con_id,
                    'cat_id' => $cat_id
                ]);
            }
        }
       
        alert()->success('Contact has been updated.');
        return redirect()->action([ContactController::class, 'manage']);
    }

    public function edit($con_uuid)
    {
        $contact = DB::table('contacts')
        ->where('con_uuid', '=', $con_uuid)
        ->first();

        $categories = DB::table('categories')
        ->where('acc_id', '=', session('acc_id'))
        ->where('cat_active', '=', '1')
        ->orderBy('cat_name')
        ->get();

        return view('admin.contacts.edit',compact('contact','categories'));
    }

    public function delete($con_uuid)
    {
        DB::table('contacts')
        ->where('con_uuid','=',$con_uuid)
        ->update([
            'con_date_modified' => Carbon::now(),
            'con_modified_by' => session('usr_id'),
            'con_active' => '0'
        ]);
       
        alert()->success('Contact has been deleted.');
        return redirect()->action([ContactController::class, 'manage']);
    }

    public function categories()
    {
        $categories = DB::table('categories')
        ->where('acc_id','=',session('acc_id'))
        ->where('cat_active','=','1')
        ->orderby('cat_name')
        ->get();
       
        return view('admin.contacts.categories',compact('categories'));
    }

    public function saveCategory(Request $request)
    {
        DB::table('categories')
        ->insert([
            'cat_uuid' => generateuuid(),
            'acc_id' => session('acc_id'),
            'cat_name' => $request->cat_name,
            'cat_active' => '1'
        ]);
       
        alert()->success('Contact category has been added.');
        return redirect()->action([ContactController::class, 'categories']);
    }

    public function updateCategory(Request $request)
    {
        DB::table('categories')
        ->where('cat_uuid','=',$request->cat_uuid)
        ->update([
            'cat_name' => $request->cat_name,
            'cat_active' => '1'
        ]);
       
        alert()->success('Contact category has been updated.');
        return redirect()->action([ContactController::class, 'categories']);
    }

    public function deleteCategory($cat_uuid)
    {
        DB::table('categories')
        ->where('cat_uuid','=',$cat_uuid)
        ->update([
            'cat_active' => '0'
        ]);
       
        alert()->success('Contact category has been deleted.');
        return redirect()->action([ContactController::class, 'categories']);
    }
}
