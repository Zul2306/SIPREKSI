<?php

namespace App\Http\Controllers;
use App\Models\Prediction; // Pastikan model ini sesuai nama
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Certificate;

class PredictionController extends Controller {
    public function form()
    {
        // Ambil daftar file CSV dari FastAPI
        $response = Http::get("http://127.0.0.1:8000/files");

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Gagal mengambil daftar file.']);
        }

        $files = $response->json()['files'] ?? [];
        return view('user.prediksi', compact('files'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|string',
            'RATA_RATA' => 'required|numeric',
            'MAT' => 'required|numeric',
            'BIO' => 'required|numeric',
            'KIM' => 'required|numeric',
            'BIG' => 'required|numeric',
            'INDEKS' => 'required|numeric',
            'certificate_average_score' => 'required|numeric'
        ]);
    
        $inputData = $request->only(['RATA_RATA', 'MAT', 'BIO', 'KIM', 'BIG', 'INDEKS']);
    
        $payload = [
            'file' => $request->file,
            'data' => $inputData,
            'certificate_average_score' => $request->certificate_average_score
        ];
        // dd($payload);

        

    
        // Logging payload sebelum dikirim ke FastAPI
        \Log::info('Payload dikirim ke FastAPI:', $payload);
    
        $response = Http::post("http://127.0.0.1:8000/predict", $payload);
        // dd($response->json());

        
    
        // Logging respons dari FastAPI
        \Log::info('Respons dari FastAPI:', $response->json());
        
    
        if ($response->failed()) {
            $errorDetail = $response->json()['detail'] ?? 'Terjadi kesalahan saat prediksi.';
            return back()->withErrors(['error' => 'Prediksi gagal: ' . $errorDetail]);
        }
        
    
        $result = $response->json();
        $prediction = $result['prediction'] ?? 'Tidak diketahui';
        $score = $result['score'] ?? 0;
        $prediction = Prediction::create([
                            'user_id'           => auth()->id(),
                            'filename'          => $validated['file'],
                            'rata_rata'         => $validated['RATA_RATA'],
                            'mat'               => $validated['MAT'],
                            'bio'               => $validated['BIO'],
                            'kim'               => $validated['KIM'],
                            'big'               => $validated['BIG'],
                            'indeks'            => $validated['INDEKS'],
                            'certificate_score' => $validated['certificate_average_score'],
                            'created_at' => now()->setTimezone('Asia/Jakarta')
            
                        ]);
                        $prediction->update([
                                            'model_prediction' => $result['prediction'],
                                            'final_score'      => $result['score'],                
                                            'result'           => number_format($result['score'], 2) . '%',
                            
                                        ]);
        
    
                                        return back()->with([
                                            'result' => number_format($result['score'], 2) . '%',
                                        ]);
                                        
    }
    

    
//     public function showForm()
//     {
//         $dataDir = 'C:\laragon\www\TUGASA\BE\data';
//         $models = [];

//         if (is_dir($dataDir)) {
//         $files = scandir($dataDir);
//         $models = array_filter($files, function ($file) {
//             return pathinfo($file, PATHINFO_EXTENSION) === 'csv';
//         });
//     }

//     return view('user.prediksi', ['models' => $models]);
//     }

// public function predict(Request $request)
// {
//     $validated = $request->validate([
//         'model' => 'required|string',
//         'RATA_RATA' => 'required|numeric',
//         'MAT' => 'required|numeric',
//         'BIO' => 'required|numeric',
//         'KIM' => 'required|numeric',
//         'BIG' => 'required|numeric',
//         'INDEKS' => 'required|numeric',
//         'certificate_average_score' => 'required|numeric', // dari input hidden
//     ]);

//     $payload = [
//         'model' => $validated['model'],
//         'data' => [
//             'RATA_RATA' => $validated['RATA_RATA'],
//             'MAT'       => $validated['MAT'],
//             'BIO'       => $validated['BIO'],
//             'KIM'       => $validated['KIM'],
//             'BIG'       => $validated['BIG'],
//             'INDEKS'    => $validated['INDEKS'],
//         ],
//         // 'certificate_average_score' => $validated['certificate_average_score']
//     ];

//     \Log::info('Payload to FastAPI:', $payload);

//     try {
//         $response = Http::withHeaders([
//             'Content-Type' => 'application/json'
//         ])->post('http://localhost:8000/predict', $payload);

//         if ($response->successful()) {
//             $result = $response->json();

//             // Simpan data awal terlebih dahulu
//             // $prediction = Prediction::create([
//             //     'user_id'           => auth()->id(),
//             //     'filename'          => $validated['model'],
//             //     'rata_rata'         => $validated['RATA_RATA'],
//             //     'mat'               => $validated['MAT'],
//             //     'bio'               => $validated['BIO'],
//             //     'kim'               => $validated['KIM'],
//             //     'big'               => $validated['BIG'],
//             //     'indeks'            => $validated['INDEKS'],
//             //     'certificate_score' => $validated['certificate_average_score'],
//             //     'created_at' => now()->setTimezone('Asia/Jakarta')

//             // ]);

//             // Update hasil prediksi setelah data berhasil disimpan
//             // $prediction->update([
//             //     'model_prediction' => $result['prediction'],
//             //     'final_score'      => $result['total_score'],                
//             //     'result'           => number_format($result['total_score'], 2) . '%',

//             // ]);

//             return back()->with([
//                 'success' => 'Sistem memprediksi kemungkinan anda Lulus',
//                 'result' => $result['prediction'],
//                 'score' => number_format($result['total_score'], 2). '%'
//             ]);
//         } else {
//             \Log::error('FastAPI error response', [
//                 'status' => $response->status(),
//                 'body' => $response->body(),
//             ]);
//             return back()->withErrors(['msg' => 'Gagal mendapatkan prediksi dari server.']);
//         }
//     } catch (\Exception $e) {
//         \Log::error('Exception saat menghubungi FastAPI:', [
//             'error' => $e->getMessage(),
//         ]);
//         return back()->withErrors(['msg' => 'Terjadi kesalahan saat menghubungi server prediksi.']);
//     }
// }

public function history()
    {
    $predictions = Prediction::where('user_id', auth()->id())
                    ->whereNotNull('result')
                    ->orderBy('created_at', 'desc')
                    ->get();

    return view('user.hasil_prediksi', compact('predictions'));
    }
    
}
