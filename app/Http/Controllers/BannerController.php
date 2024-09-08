<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use DB;

class BannerController extends Controller
{
    public function main()
    {
        $banners = DB::table('banners')
        ->where('ban_active', '=', '1')
        ->orderBy('ban_order','ASC')
        ->get();

        foreach($banners AS $banner){
            if($banner->ban_is_expirable == '1' AND Carbon::parse($banner->ban_date_expiry) <= Carbon::parse(date("Y-m-d"))){
                DB::table('banners')
                ->where('ban_id','=',$banner->ban_id)
                ->update([
                    'ban_active' => '0'
                ]);
            }
        }

        return view('banner.main',compact('banners'));
    }

    public function save(Request $request)
    {
        if ($request->has('ban_image')) {
            $file = $request->file('ban_image'); 

            if(isset($file)){
                $validator = Validator::make( 
                    [
                        'file' => $file,
                        'extension' => strtolower($file->getClientOriginalExtension()),
                    ],
                    [
                        'file' => 'required',
                        'extension' => 'required|in:jpg,png',
                    ]
                );
                  
                if ($validator->fails()) {
                    session()->flash('error_message',  "Invalid File Extension!");
                    return redirect()->back();
                }
            }
    
            $file = $request->file('ban_image');
            $filename =  $file->getClientOriginalName();

            $ban_title = $request->ban_title;
            $ban_subtitle = $request->ban_subtitle;
            $ban_order = $request->ban_order;
            $ban_show_button_1 = $request->ban_show_button_1;
            $ban_show_button_2 = $request->ban_show_button_2;
            $ban_is_expirable = $request->ban_is_expirable;

            if($ban_show_button_1 == null){
                $ban_show_button_1 = '0';
            }

            if($ban_show_button_2 == null){
                $ban_show_button_2 = '0';
            }

            if($ban_is_expirable == null){
                $ban_is_expirable = '0';
            }

            $ban_button_1_text = $request->ban_button_1_text;
            $ban_button_1_link = $request->ban_button_1_link;
            $ban_button_2_text = $request->ban_button_2_text;
            $ban_button_2_link = $request->ban_button_2_link;
            $ban_date_expiry = $request->ban_date_expiry;

            $new_file_name = generateuuid() . '.' . $file->getClientOriginalExtension();

            DB::table('banners')
            ->insert([
                'ban_title' => $ban_title,
                'ban_subtitle' => $ban_subtitle,
                'ban_order' => $ban_order,
                'ban_show_button_1' => $ban_show_button_1,
                'ban_show_button_2' => $ban_show_button_2,
                'ban_is_expirable' => $ban_is_expirable,
                'ban_button_1_text' => $ban_button_1_text,
                'ban_button_1_link' => $ban_button_1_link,
                'ban_button_2_text' => $ban_button_2_text,
                'ban_button_2_link' => $ban_button_2_link,
                'ban_date_expiry' => $ban_date_expiry,
                'ban_image' => $new_file_name,
                'ban_created_by' => session('usr_id'),
                'ban_date_created' => Carbon::now(),
                'ban_active' => '1'
            ]);

            Storage::disk('public')->put('/images/slider-main/' . $new_file_name, fopen($request->file('ban_image'), 'r+'));
            
            session()->flash('success_message', 'Banner has been saved.');
            return redirect()->action([BannerController::class, 'main']);
        }else{
            session()->flash('error_message', 'No image file attached.');
            return redirect()->action([BannerController::class, 'main']);
        }
    }

    public function delete($ban_id)
    {
        DB::table('banners')
        ->where('ban_id','=',$ban_id)
        ->update([
            'ban_updated_by' => session('usr_id'),
            'ban_date_updated' => Carbon::now(),
            'ban_active' => '0'
        ]);

        session()->flash('success_message', 'Banner has been deleted.');
        return redirect()->action([BannerController::class, 'main']);
    }

    public function update(Request $request)
    {
        $ban_id = $request->ban_id;
        $ban_title = $request->ban_title;
        $ban_subtitle = $request->ban_subtitle;
        $ban_order = $request->ban_order;
        $ban_show_button_1 = $request->ban_show_button_1;
        $ban_show_button_2 = $request->ban_show_button_2;
        $ban_is_expirable = $request->ban_is_expirable;

        if($ban_show_button_1 == null){
            $ban_show_button_1 = '0';
        }

        if($ban_show_button_2 == null){
            $ban_show_button_2 = '0';
        }

        if($ban_is_expirable == null){
            $ban_is_expirable = '0';
        }

        $ban_button_1_text = $request->ban_button_1_text;
        $ban_button_1_link = $request->ban_button_1_link;
        $ban_button_2_text = $request->ban_button_2_text;
        $ban_button_2_link = $request->ban_button_2_link;
        $ban_date_expiry = $request->ban_date_expiry;

        DB::table('banners')
        ->where('ban_id','=',$ban_id)
        ->update([
            'ban_title' => $ban_title,
            'ban_subtitle' => $ban_subtitle,
            'ban_order' => $ban_order,
            'ban_show_button_1' => $ban_show_button_1,
            'ban_show_button_2' => $ban_show_button_2,
            'ban_is_expirable' => $ban_is_expirable,
            'ban_button_1_text' => $ban_button_1_text,
            'ban_button_1_link' => $ban_button_1_link,
            'ban_button_2_text' => $ban_button_2_text,
            'ban_button_2_link' => $ban_button_2_link,
            'ban_date_expiry' => $ban_date_expiry,
            'ban_updated_by' => session('usr_id'),
            'ban_date_updated' => Carbon::now(),
        ]);

        session()->flash('success_message', 'Banner has been updated.');
        return redirect()->action([BannerController::class, 'main']);
    }
}
