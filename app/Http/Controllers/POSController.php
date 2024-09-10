<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class POSController extends Controller
{
    public function pos_receive_main()
    {
        $categories = DB::table('menu_categories')
            ->where('mcat_active', '=', 1)
            ->get();

        // Join the menus with menu_categories to get mcat_name
        $menus = DB::table('menus')
            ->join('menu_categories', 'menus.mcat_id', '=', 'menu_categories.mcat_id')
            ->where('menus.menu_active', '=', 1)
            ->select('menus.*', 'menu_categories.mcat_name')
            ->get();

        return view('admin.pos.point_of_sale', compact('categories', 'menus'));
    }

    public function payment(Request $request)
    {
        // Begin transaction
        DB::beginTransaction();

        // Insert into menu_transactions
        $menuTransactionId = DB::table('menu_transactions')->insertGetId([
            'mtrx_total_orders' => $request->input('mtrx_total_orders'),
            'mtrx_total' => $request->input('mtrx_total'),
            'mtrx_cash' => $request->input('mtrx_cash'),
            'mtrx_change' => $request->input('mtrx_change'),
            'mtrx_discount_whole' => $request->input('mtrx_discount_whole', null),
            'mtrx_discount_percent' => $request->input('mtrx_discount_percent', null),
            'mtrx_date_created' => Carbon::now(),
            'mtrx_created_by' => session('usr_id'),
            'mtrx_active' => 1
        ]);

        // Get order arrays from request
        $menuNames = $request->input('menu_name', []);
        $mcatNames = $request->input('mcat_name', []);
        $orderPrices = $request->input('mtrxo_order_price', []);
        $orderQuantities = $request->input('mtrxo_order_quantity', []);
        $totalAmounts = $request->input('mtrxo_total_amount', []);

        // Iterate through the orders
        foreach ($menuNames as $index => $menuName) {
            DB::table('menu_transaction_orders')->insert([
                'mtrx_id' => $menuTransactionId,
                'menu_name' => $menuName,
                'mcat_name' => $mcatNames[$index] ?? null,
                'mtrxo_order_quantity' => $orderQuantities[$index] ?? 0,
                'mtrxo_order_price' => $orderPrices[$index] ?? 0,
                'mtrxo_total_amount' => $totalAmounts[$index] ?? 0,
                'mtrxo_date_created' => Carbon::now(),
                'mtrxo_created_by' => session('usr_id'),
                'mtrxo_active' => 1
            ]);
        }

        // Commit the transaction
        DB::commit();

        // Redirect or return success response
        return redirect('pos/receive/new-transaction')->with('success', 'Transaction completed successfully.');
    }

    public function transaction_history()
    {
        return view('admin.pos.transaction_history');
    }
}
