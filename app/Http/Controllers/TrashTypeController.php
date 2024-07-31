<?php

namespace App\Http\Controllers;

use App\Models\TrashType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TrashTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contents.meta-data.meta-data-trash-type.index');
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
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {    

            TrashType::find($id)->delete();

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(),]);
        }
    
        return response()->json(['status' => true, 'message' => 'Berhasil meta data type sampah!',]);
    }

    public function datatable(Request $request)
    {
        
        $data = TrashType::get();

        return DataTables::of($data)->make();
    }
}
