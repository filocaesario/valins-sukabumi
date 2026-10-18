<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ValinsService;
use Illuminate\Http\Request;

class ValinsApiController extends Controller
{
    // Fungsi untuk mengambil data (GET)
    public function index()
    {
        // Menarik 50 data terbaru agar tidak memberatkan server
        $data = ValinsService::orderBy('updated_at', 'desc')->take(50)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Valins berhasil diambil',
            'data' => $data
        ], 200);
    }

    // Fungsi untuk menambah data (POST)
    public function store(Request $request)
    {
        try {
            $valins = ValinsService::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan dari API',
                'data' => $valins
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
}
