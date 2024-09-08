<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;


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

        return view('pos.pos_receive', compact('categories', 'menus'));
    }

    public function pos_confirm()
    {

    }

    // @ OHAHA PURCHASES

    public function pos_purchase_main()
    {
        $clients = DB::table('clients')
            ->where('clt_active', '=', 1)
            ->get();

        $categories = DB::table('product_categories')
            ->where('cat_active', '=', 1)
            ->get();

        $products = DB::table('products')
            ->join('suppliers', 'products.sup_id', '=', 'suppliers.sup_id')
            ->join('product_categories', 'products.cat_id', '=', 'product_categories.cat_id')
            ->leftJoin('product_sub_categories', 'products.psc_id', '=', 'product_sub_categories.psc_id')
            ->leftJoin('product_category_values', function ($join) {
                $join->on('products.prd_id', '=', 'product_category_values.prd_id')
                    ->on('products.cat_id', '=', 'product_category_values.cat_id');
            })
            ->leftJoin('product_sub_category_values', function ($join) {
                $join->on('products.prd_id', '=', 'product_sub_category_values.prd_id')
                    ->on('products.psc_id', '=', 'product_sub_category_values.psc_id');
            })
            ->select(
                'products.*',
                'product_categories.cat_name as category_name',
                'product_sub_categories.psc_name as sub_category_name',
                'product_category_values.pcv_value as category_value',
                'product_sub_category_values.pscv_value as sub_category_value'
            )
            ->orderBy('product_categories.cat_name')
            ->orderBy('product_sub_categories.psc_name')
            ->orderBy('products.prd_name')
            ->get();

        $temp_items = DB::table('temp_po_transactions')
            ->join('products', 'products.prd_id', '=', 'temp_po_transactions.prd_id')
            ->join('product_categories', 'product_categories.cat_id', '=', 'products.cat_id')
            ->leftJoin('product_category_values', function ($join) {
                $join->on('products.prd_id', '=', 'product_category_values.prd_id')
                    ->on('products.cat_id', '=', 'product_category_values.cat_id');
            })
            ->where('tpo_active', '=', 1)
            ->select(
                'temp_po_transactions.*',
                'products.prd_id',
                'products.prd_name',
                'product_categories.cat_name',
                'product_category_values.pcv_value',
            )
            ->get();

        return view('pos.pos_purchase', compact('clients', 'categories', 'products', 'temp_items'));
    }

    public function pos_purchase_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_quantity' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Failed to add item! Minimum quantity is 1.');
            return redirect()->back();
        }

        $item_prd_id = $request->input('item_prd_id');
        $item_price = $request->input('item_price');
        $item_quantity = $request->input('item_quantity');

        $item_total_price = $item_price * $item_quantity;

        $temp_PO_txn_products = DB::table('temp_po_transactions')
            ->insert([
                'prd_id' => $item_prd_id,
                'tpo_quantity' => $item_quantity,
                'tpo_prd_price' => $item_price,
                'tpo_total_price' => $item_total_price
            ]);

        if ($temp_PO_txn_products) {
            return redirect()->back();
        } else {
            alert()->error('Error', 'Error adding item.');
            return redirect()->back();
        }
    }

    public function pos_purchase_add_transaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products.*.po_prd_quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Check the quantities of selected items! Minimum is 1');
            return redirect()->back();
        }

        $new_txn = DB::table('transactions')
            ->insertGetId([
                'txn_number' => getTransactionNumber(),
                'txn_total_quantity' => $request->input('total_quantity'),
                'txn_total_amount' => $request->input('grand_total'),
                'txn_date' => DB::RAW('CURRENT_TIMESTAMP'),
                'txn_created_by' => session('usr_id'),
            ]);

        $products = $request->input('products', []);

        if ($new_txn) {
            foreach ($products as $product) {

                DB::table('product_out')
                    ->insert([
                        'prd_id' => $product['prd_id'],
                        'clt_id' => $request->input('clt_id'),
                        'txn_id' => $new_txn,
                        'po_product_price' => $product['po_product_price'],
                        'po_prd_quantity' => $product['po_prd_quantity'],
                        'po_total_amount' => $product['po_total_amount'],
                        'po_date' => DB::RAW('CURRENT_TIMESTAMP'),
                        'po_created_by' => session('usr_id'),
                    ]);
                // Access each field, e.g., $product['prd_id'], $product['po_prd_quantity'], etc.
                // Save or process the product data as needed
                // $transaction = new Transaction(); // Assuming you have a Transaction model
                // $transaction->prd_id = $product['prd_id'];
                // $transaction->quantity = $product['po_prd_quantity'];
                // $transaction->price = $product['po_product_price'];
                // $transaction->total_amount = $product['po_total_amount'];
                // $transaction->save();

                DB::table('products')
                    ->where('prd_id', '=', $product['prd_id'])
                    ->update([
                        'prd_stock_quantity' => DB::raw('prd_stock_quantity - ' . $product['po_prd_quantity']),
                    ]);
            }
        } else {
            alert()->error('Error', 'An error occured! Please try again.');
            return redirect()->back();
        }

        DB::table('temp_po_transactions')->truncate();

        alert()->Success('Success', 'Transaction Completed');
        return redirect()->back();

        // if ($temp_PO_txn_products) {
        //     return redirect()->back();
        // } else {
        //     alert()->error('Error', 'Error adding item.');
        //     return redirect()->back();
        // }
    }

    // ! OHAHA DAMAGES

    public function pos_damages_main()
    {
        $clients = DB::table('clients')
            ->where('clt_active', '=', 1)
            ->get();

        $categories = DB::table('product_categories')
            ->where('cat_active', '=', 1)
            ->get();

        $products = DB::table('products')
            ->join('suppliers', 'products.sup_id', '=', 'suppliers.sup_id')
            ->join('product_categories', 'products.cat_id', '=', 'product_categories.cat_id')
            ->leftJoin('product_sub_categories', 'products.psc_id', '=', 'product_sub_categories.psc_id')
            ->leftJoin('product_category_values', function ($join) {
                $join->on('products.prd_id', '=', 'product_category_values.prd_id')
                    ->on('products.cat_id', '=', 'product_category_values.cat_id');
            })
            ->leftJoin('product_sub_category_values', function ($join) {
                $join->on('products.prd_id', '=', 'product_sub_category_values.prd_id')
                    ->on('products.psc_id', '=', 'product_sub_category_values.psc_id');
            })
            ->select(
                'products.*',
                'product_categories.cat_name as category_name',
                'product_sub_categories.psc_name as sub_category_name',
                'product_category_values.pcv_value as category_value',
                'product_sub_category_values.pscv_value as sub_category_value'
            )
            ->orderBy('product_categories.cat_name')
            ->orderBy('product_sub_categories.psc_name')
            ->orderBy('products.prd_name')
            ->get();

        $temp_items = DB::table('temp_po_transactions')
            ->join('products', 'products.prd_id', '=', 'temp_po_transactions.prd_id')
            ->join('product_categories', 'product_categories.cat_id', '=', 'products.cat_id')
            ->leftJoin('product_category_values', function ($join) {
                $join->on('products.prd_id', '=', 'product_category_values.prd_id')
                    ->on('products.cat_id', '=', 'product_category_values.cat_id');
            })
            ->where('tpo_active', '=', 1)
            ->select(
                'temp_po_transactions.*',
                'products.prd_id',
                'products.prd_name',
                'product_categories.cat_name',
                'product_category_values.pcv_value',
            )
            ->get();

        return view('pos.pos_damage', compact('clients', 'categories', 'products', 'temp_items'));
    }

    public function pos_damages_add()
    {
        return view('admin.dashboard.main');
    }

}
