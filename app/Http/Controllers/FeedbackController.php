<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\Complaint;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ComplaintResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contents.feedback.index');
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $complaintResponse = ComplaintResponse::where('complaint_id', $id)->first();

        $garbage = $complaintResponse->user_id;
        $userData = UserData::where('user_id', $garbage)->first();
        $garbageOfficerName = $userData ? $userData->name : null;
        // dd($garbageOfficerName);
        if ($complaintResponse) {
            return response()->json([
                'dataComplaintResponse' => $complaintResponse,
                'dataPetugas' => $garbageOfficerName,
            ]);
        } else {
            return response()->json([
                'message' => 'teknisi tidak ditemukan.',
            ], 404);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $Complaint = ComplaintResponse::where($id);
        // dd($Complaint);
        // if ($Complaint) {
        //     return response()->json([
        //         'data' => $Complaint,
        //     ]);
        // } else {
        //     return response()->json([
        //         'message' => 'Data complaint tidak ditemukan.',
        //     ], 404);
        // }
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
        //
    }

    public function datatable(Request $request)
{
    $data = Complaint::with('user', 'user.userData' ,'response')->get();

    return DataTables::of($data)
        ->editColumn('image', function ($data) {
            $storagePath = storage_path('app/public/' . $data->image);
            if (file_exists($storagePath)) {
                $imagePath = asset('storage/' . $data->image);
            } else {
                $imagePath = asset('assets/images/faces/1.jpg');
            }
            return $imagePath;
        })
        ->make(true);
}

    
    public function needsValidation(Request $request)
    {
        // dd($request);
        $complaint = Complaint::find($request->id);

        if ($complaint) {
            $complaint->update([
                'status' => $request->state,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Success Update Complaint!',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data not found!',
            ], 404); // or handle the situation according to your requirements
        }
    }

    public function onHold(Request $request)
    {
        // dd($request);
        $complaint = Complaint::find($request->id);

        if ($complaint) {
            $complaint->update([
                'status' => $request->state,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Success Update Complaint!',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data not found!',
            ], 404); // or handle the situation according to your requirements
        }
    }
}
