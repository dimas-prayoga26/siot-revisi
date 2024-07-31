<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetaDuesNominals;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class MetaDuesNominalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contents.meta-data.meta-data-dues-nominals.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nominal' => 'required|integer',
        ];
        
    
        // Validate request data
        $validator = Validator::make($request->all(), $rules);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
    
            $metaDuesNominal = MetaDuesNominals::create([
                'nominal' => $request->nominal
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Success Add Data Nominal!',
            ]);
    
        } catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'status' => false,
                'message' => 'Error occurred while adding data nominal.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $metaDuesNominal = MetaDuesNominals::where('id', $id)->get(); // Ambil semua data pengguna dan ubah menjadi format pluck
        // dd($Users);
        if ($metaDuesNominal ) {
            return response()->json([
                'data' => $metaDuesNominal,
            ]);
        } else {
            return response()->json([
                'message' => 'Customer tidak ditemukan.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'nominal' => 'required|integer',
            ]);

            // Mendapatkan ID alamat dari permintaan
            $metaDuesNominal = $request->id;

            // Memperbarui informasi pelanggan
            $nominal = MetaDuesNominals::findOrFail($metaDuesNominal);
            $nominal->update([
                'nominal' => $request->nominal,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Nominal updated successfully!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update nominal.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {    
            MetaDuesNominals::find($id)->delete();

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(),]);
        }
    
        return response()->json(['status' => true, 'message' => 'Success Delete Admin!',]);
    }

    public function datatable(Request $request)
    {
        $data = MetaDuesNominals::get();

        return DataTables::of($data)->make();
    }
}
