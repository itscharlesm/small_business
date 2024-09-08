<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UtilityController extends Controller
{
    public function product_details()
    {
        $categories = DB::table('product_categories')
            ->where('cat_active', '=', 1)
            ->get();

        $sub_categories = DB::table('product_sub_categories')
            ->where('psc_active', '=', 1)
            ->get();

        $suppliers = DB::table('suppliers')
            ->where('sup_active', '=', 1)
            ->get();

        // Pass the user data to the view
        $products = DB::table('products')
            ->join('suppliers', 'products.sup_id', '=', 'suppliers.sup_id')
            ->join('product_categories', 'products.cat_id', '=', 'product_categories.cat_id')
            ->join('price_type', 'products.prd_id', '=', 'price_type.prd_id')
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
                'suppliers.sup_name',
                'price_type.price_typ_retail as price_retail',
                'price_type.price_typ_dealer as price_dealer',
                'product_categories.cat_name as category_name',
                'product_sub_categories.psc_name as sub_category_name',
                'product_category_values.pcv_value as category_value',
                'product_sub_category_values.pscv_value as sub_category_value'
            )
            ->orderBy('product_categories.cat_name')
            ->orderBy('product_sub_categories.psc_name')
            ->orderBy('products.prd_name')
            ->get();

        return view('admin.utility.product_details', compact('products', 'categories', 'sub_categories', 'suppliers'));
    }

    public function add_new_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prd_name' => 'required|string|max:255',
            'cat_id' => 'required|exists:product_categories,cat_id',
            // 'psc_id' => 'required|exists:product_sub_categories,psc_id',
            'sup_id' => 'required|exists:suppliers,sup_id',
            'pcv_value' => 'nullable|string|max:50',
            'price_typ_retail' => 'required|numeric|min:0',
            'price_typ_dealer' => 'required|numeric|min:0',
            'prd_price_purchase' => 'required|numeric|min:0',
            'prd_stock_quantity' => 'required|integer',
            'prd_sku_number' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Failed to add product! Please try again.');
            return redirect()->back();
        }

        $product = DB::table('products')
            ->insertGetId([
                'prd_name' => $request->input('prd_name'),
                'cat_id' => $request->input('cat_id'),
                // 'psc_id' => $request->input('psc_id'),
                'sup_id' => $request->input('sup_id'),
                // 'prd_price_retail' => $request->input('prd_price_retail'),
                // 'prd_price_dealer' => $request->input('prd_price_dealer'),
                'prd_price_purchase' => $request->input('prd_price_purchase'),
                'prd_stock_quantity' => $request->input('prd_stock_quantity'),
                'prd_sku_number' => $request->input('prd_sku_number'),

                'prd_created_by' => session('usr_id'),
                'prd_date_created' => DB::RAW('CURRENT_TIMESTAMP'),
            ]);
        
        DB::table('price_type')
            ->insert([
                'prd_id' => $product,
                'price_typ_retail' => $request->input('price_typ_retail'),
                'price_typ_dealer' => $request->input('price_typ_dealer'),
            ]);

        if ($request->input('prd_name') != null && $product) {
            DB::table('product_category_values')
                ->insert([
                    'prd_id' => $product,
                    'cat_id' => $request->input('cat_id'),
                    'pcv_value' => $request->input('pcv_value'),
                ]);
        }

        alert()->success('Success', 'New Product Added.');
        return redirect()->back();

        // // Create the product
        // $product_id = DB::table('products')->insertGetId([
        //     'name' => $request->input('name'),
        //     'category_id' => $request->input('category_id'),
        //     'sub_category_id' => $request->input('sub_category_id'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // // Insert the attribute into the appropriate table
        // if ($request->filled('sub_category_id')) {
        //     // If there is a subcategory
        //     DB::table('product_sub_category_values')->insert([
        //         'product_id' => $product_id,
        //         'sub_category_id' => $request->input('sub_category_id'),
        //         'value' => 'Color: ' . $request->input('color'),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // } else {
        //     // If there is no subcategory
        //     DB::table('product_category_values')->insert([
        //         'product_id' => $product_id,
        //         'category_id' => $request->input('category_id'),
        //         'value' => 'Color: ' . $request->input('color'),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }


        // Pass the user data to the view
        // return view('admin.utility.product_details', compact('user'));
    }

    // !

    public function product_categories()
    {
        $categories = DB::table('product_categories')
            ->where('cat_active', '=', 1)
            ->get();

        return view('admin.utility.product_categories', compact('categories'));
    }

    public function add_product_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Failed to add Category! Please try again.');
            return redirect()->back();
        }

        $category = DB::table('product_categories')
            ->insertGetId([
                'cat_name' => $request->input('cat_name'),
                'cat_created_by' => session('usr_id'),
                'cat_date_created' => DB::RAW('CURRENT_TIMESTAMP'),
            ]);

        alert()->success('Success', 'New Category created.');
        return redirect()->back();
    }

    // !

    public function clients_manage()
    {
        $clients = DB::table('clients')
            ->where('clt_active', '=', 1)
            ->get();

        return view('admin.utility.clients', compact('clients'));
    }

    public function add_clients_manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clt_name' => 'required|string|max:255',
            'clt_address' => 'required|string|max:255',
            'clt_contact' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Failed to add new Client! Please try again.');
            return redirect()->back();
        }

        DB::table('clients')
            ->insert([
                'clt_name' => $request->input('clt_name'),
                'clt_address' => $request->input('clt_address'),
                'clt_contact' => $request->input('clt_contact'),
                'clt_created_by' => session('usr_id'),
                'clt_date_created' => DB::RAW('CURRENT_TIMESTAMP')
            ]);

        alert()->success('Success', 'New Client created.');
        return redirect()->back();
    }

    // !


    public function suppliers_manage()
    {
        $suppliers = DB::table('suppliers')
            ->where('sup_active', '=', 1)
            ->get();

        return view('admin.utility.suppliers', compact('suppliers'));
    }

    public function add_suppliers_manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sup_name' => 'required|string|max:255',
            'sup_address' => 'required|string|max:255',
            'sup_contact' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Failed to add new Supplier! Please try again.');
            return redirect()->back();
        }

        DB::table('suppliers')
            ->insert([
                'sup_name' => $request->input('sup_name'),
                'sup_address' => $request->input('sup_address'),
                'sup_contact' => $request->input('sup_contact'),
                'sup_created_by' => session('usr_id'),
                'sup_date_created' => DB::RAW('CURRENT_TIMESTAMP')
            ]);

        alert()->success('Success', 'New Supplier created.');
        return redirect()->back();
    }

    // public function welcome()
    // {
    //     return view('admin.welcome');
    // }

    // public function dashboard(Request $request)
    // {
    //     $currentDate = Carbon::now();
    //     $currentYear = $currentDate->year;

    //     $startDate = Carbon::create(2024, 1, 1)->startOfDay()->toDateString();

    //     $endDate = $currentDate->startOfDay()->toDateString();

    //     $defaultTopBorrowedEquipment = DB::table('borrow_requests')
    //         ->select(
    //             'equipments.eqp_name',
    //             'borrowers.bor_id',
    //             DB::raw('SUM(borrow_requests.res_quantity) as total_quantity'),
    //             DB::raw('SUM(equipments.eqp_quantity) as totalQuantity'),
    //             DB::raw("CONCAT(borrowers.bor_first_name, ' (', borrowers.bor_code, ')') as borrower_name_code")
    //         )
    //         ->join('equipments', 'equipments.eqp_id', '=', 'borrow_requests.eqp_id')
    //         ->join('borrowers', 'borrowers.bor_id', '=', 'borrow_requests.bor_id')
    //         ->whereBetween('borrow_requests.res_date_requested', [$startDate, $endDate])
    //         ->groupBy('equipments.eqp_name', 'borrowers.bor_id', 'borrowers.bor_first_name', 'borrowers.bor_code')
    //         ->orderByDesc('total_quantity')
    //         ->limit(10)
    //         ->get();

    //     if ($defaultTopBorrowedEquipment->isEmpty()) {
    //         return response()->json(['error' => 'No default data found'], 404);
    //     }

    //     $data = [
    //         'startDate' => $startDate,
    //         'endDate' => $endDate,
    //     ];

    //     return view('admin.dashboard', $data, compact('defaultTopBorrowedEquipment'));
    // }

}
