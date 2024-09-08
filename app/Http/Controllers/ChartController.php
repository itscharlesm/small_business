<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChartController extends Controller
{
    public function search(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        if (!$fromDate || !$toDate) {
            return response()->json(['error' => 'Both from_date and to_date are required'], 400);
        }

        if (!strtotime($fromDate) || !strtotime($toDate)) {
            return response()->json(['error' => 'Invalid date format. Please use YYYY-MM-DD format.'], 400);
        }

        $filteredData = DB::table('borrow_requests')
            ->select(
                'equipments.eqp_name',
                'borrowers.bor_id',
                DB::raw('SUM(borrow_requests.res_quantity) as total_quantity'),
                DB::raw('SUM(equipments.eqp_quantity) as totalQuantity'),
                DB::raw("CONCAT(borrowers.bor_first_name, ' (', borrowers.bor_code, ')') as borrower_name_code")
            )
            ->join('equipments', 'equipments.eqp_id', '=', 'borrow_requests.eqp_id')
            ->join('borrowers', 'borrowers.bor_id', '=', 'borrow_requests.bor_id')
            ->whereBetween('borrow_requests.res_date_requested', [$fromDate,$toDate])
            ->groupBy('equipments.eqp_name', 'borrowers.bor_id', 'borrowers.bor_first_name', 'borrowers.bor_code')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        if ($filteredData->isEmpty()) {
            return response()->json(['error' => 'No data found for the selected date range'], 404);
        }

        foreach ($filteredData as $equipment) {
            $equipment->percentage = round(($equipment->total_quantity / $equipment->totalQuantity) * 100);
        }

        $barChartData = $filteredData->map(function ($item) {
            return [
                'eqp_name' => $item->eqp_name,
                'total_quantity' => $item->total_quantity,
            ];
        });

        $pieChartData = $filteredData->map(function ($item) {
            return [
                'eqp_name' => $item->eqp_name,
                'percentage' => $item->percentage,
            ];
        });

        $topBorrowersBarChartData = $filteredData->map(function ($item) {
            return [
                'borrower_name_code' => $item->borrower_name_code,
                'total_quantity' => $item->total_quantity,
            ];
        });

        $data = [
            'filtered_bar_chart_data' => $barChartData,
            'filtered_top_borrowers_bar_chart_data' => $topBorrowersBarChartData,
            'filtered_pie_chart_data' => $pieChartData,
        ];

        return response()->json($data);
    }

    public function defaultCharts()
    {
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;

        $startDate = Carbon::create(2024, 1, 1)->startOfDay()->toDateString();

        $endDate = $currentDate->startOfDay()->toDateString();

        $defaultTopBorrowedEquipment = DB::table('borrow_requests')
            ->select(
                'equipments.eqp_name',
                'borrowers.bor_id',
                DB::raw('SUM(borrow_requests.res_quantity) as total_quantity'),
                DB::raw('SUM(equipments.eqp_quantity) as totalQuantity'),
                DB::raw("CONCAT(borrowers.bor_first_name, ' (', borrowers.bor_code, ')') as borrower_name_code")
            )
            ->join('equipments', 'equipments.eqp_id', '=', 'borrow_requests.eqp_id')
            ->join('borrowers', 'borrowers.bor_id', '=', 'borrow_requests.bor_id')
            ->whereBetween('borrow_requests.res_date_requested', [$startDate, $endDate])
            ->groupBy('equipments.eqp_name', 'borrowers.bor_id', 'borrowers.bor_first_name', 'borrowers.bor_code')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        if ($defaultTopBorrowedEquipment->isEmpty()) {
            return response()->json(['error' => 'No default data found'], 404);
        }

        foreach ($defaultTopBorrowedEquipment as $equipment) {
            $equipment->percentage = round(($equipment->total_quantity / $equipment->totalQuantity) * 100);
        }

        $barChartData = $defaultTopBorrowedEquipment->map(function ($item) {
            return [
                'eqp_name' => $item->eqp_name,
                'total_quantity' => $item->total_quantity,
            ];
        });

        $pieChartData = $defaultTopBorrowedEquipment->map(function ($item) {
            return [
                'eqp_name' => $item->eqp_name,
                'percentage' => $item->percentage,
            ];
        });

        $topBorrowersBarChartData = $defaultTopBorrowedEquipment->map(function ($item) {
            return [
                'borrower_name_code' => $item->borrower_name_code,
                'total_quantity' => $item->total_quantity,
            ];
        });

        $data = [
            'default_bar_chart_data' => $barChartData,
            'top_borrowers_bar_chart_data' => $topBorrowersBarChartData,
            'pie_chart_data' => $pieChartData,
        ];

        return response()->json($data);
    }


}
