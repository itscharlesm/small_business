<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home()
    {
        $logins = DB::table('logins')
            ->select('users.usr_last_name', 'users.usr_first_name', 'users.usr_image_path', 'logins.*', DB::raw('max(logins.log_date) as log_date_max'))
            ->join('users', 'users.usr_id', 'logins.usr_id')
            ->orderBy('log_date_max', 'desc')
            ->groupby('logins.usr_id')
            ->limit(3)
            ->get();

        $announcements = DB::table('announcements')
            ->join('users', 'users.usr_id', 'announcements.ann_created_by')
            ->where('ann_active', '=', '1')
            ->orderBy('ann_date_created', 'DESC')
            ->limit(6)
            ->get();

        return view('admin.dashboard.main', compact('logins', 'announcements'));
    }

    public function setup()
    {
        // Assuming the logged-in user's ID is stored in the session or retrieved via Auth
        $userId = session('usr_id');

        // Fetch the user's information
        $user = DB::table('users')
            ->where('usr_id', $userId)
            ->first();

        // Pass the user data to the view
        return view('admin.setup.steps', compact('user'));
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
