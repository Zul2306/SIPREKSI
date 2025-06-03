<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class DashboardController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id(); // atau dari session
    return view('user.dashboard', compact('userId')); // Akan memanggil file resources/views/user/dashboard.blade.php
    }
    public function getChartData($user_id, Request $request) 
{  
    $start = $request->query('start');
    $end = $request->query('end');

    // Validasi format tanggal
    if (!$start || !$end || !Carbon::hasFormat($start, 'Y-m-d') || !Carbon::hasFormat($end, 'Y-m-d')) {
        return response()->json([], 400); // Bad Request
    }

    $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
    $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();

    $results = DB::table('predictions')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(result) as result'))
        ->where('user_id', $user_id)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->get();

    return response()->json($results);
} 
public function getDetailData(Request $request)
{
    $user_id = $request->query('user_id');
    $date = $request->query('date');

    if (!$user_id || !$date || !Carbon::hasFormat($date, 'Y-m-d')) {
        return response()->json(['error' => 'Invalid input'], 400);
    }

    $details = DB::table('predictions')
        ->select('rata_rata', 'mat', 'bio', 'kim', 'big', 'certificate_score')
        ->where('user_id', $user_id)
        ->whereDate('created_at', $date)
        ->get();

    return response()->json($details);
}

    

}
