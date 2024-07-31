<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TrashBinCounter;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrashBinCounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contents.trash-bin-counter.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('contents.trash-bin-counter.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'max_weight'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', getError($validator->errors()->all()))
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $trashBinCounter = TrashBinCounter::create([
                'name_trash_counter' => $request->name,
                'unique_id' => $request->unique_id,
                'max_weight' => $request->max_weight,
                'is_active' => false,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        return redirect()->route('trash-counter.index')->with('success', 'Berhasil membuat alat baru!');
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

            TrashBinCounter::find($id)->delete();

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(),]);
        }
    
        return response()->json(['status' => true, 'message' => 'Berhasil menghapus alat!',]);
    }

    public function isActive(Request $request)
    {
        // dd($request);
        $trashBinCounter = TrashBinCounter::find($request->id);

        if ($trashBinCounter) {
            $trashBinCounter->update([
                'is_active' => $request->state,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Success Update Data!',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data not found!',
            ], 404); // or handle the situation according to your requirements
        }
    }


    public function datatable(Request $request)
    {
        
        $data = TrashBinCounter::get();

        return DataTables::of($data)->make();
    }
}
