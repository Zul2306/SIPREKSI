<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;

class AdminController extends Controller
{
    public function index() {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }
    

    // public function read()
    // {
    //     $users = User::all();
    //     return view('admin.dashboard', compact('users'));
    // }
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect('/admin/dashboard')->with('success', 'Pengguna berhasil dihapus.');
    }
//     public function getChartData(Request $request)
// {
//     $userId = $request->query('user_id');

//     $data = DB::table('predictions')
//         ->selectRaw('DATE(created_at) as date, result')
//         ->where('user_id', $userId)
//         ->groupByRaw('DATE(created_at), result')
//         ->orderBy('date')
//         ->get();

//     return response()->json($data);
// }
public function showByKelas($id)
{
     $kelas = Kelas::with('users')->findOrFail($id);
    $users = $kelas->users;

    return view('admin.prediksi_list', compact('kelas', 'users'));
}
// PredictionController.php
public function getChartDataByUser($user_id)
{
    $predictions = \App\Models\Prediction::where('user_id', $user_id)
        ->orderBy('created_at')
        ->get(['created_at', 'result']);

    // Format data
    $data = $predictions->map(function ($item) {
        return [
            'created_at' => $item->created_at->format('Y-m-d'),
            'result' => floatval($item->result),
        ];
    });

    return response()->json($data);
}
public function __construct()
{
    $this->middleware('auth:admin');
}



}
