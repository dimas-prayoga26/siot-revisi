<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dueses;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Exports\DuesesExport;
use Illuminate\Support\Carbon;
use App\Models\MetaDuesNominals;
use Yajra\DataTables\DataTables;

class DuesesController extends Controller
{
    protected $excel;

public function __construct(Excel $excel)
{
    $this->excel = $excel;
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data pengguna beserta status pembayaran mereka
        $users = User::with(['userData', 'dueses' => function($query) {
            $query->orderBy('created_at', 'desc')->first();
        }])->whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();

        // Ambil data nominal dari MetaDuesNominals
        $nominals = MetaDuesNominals::all();

        return view('contents.dueses.index', compact('users', 'nominals'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       // Ambil ID dan Nama User yang memiliki peran 'user', sudah memiliki TrashBin, dan belum memiliki Dues
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })
        ->whereHas('trashBin')
        ->whereDoesntHave('dueses')
        ->with('userData')
        ->get();

        // Ambil nominal dari tabel meta_dueses_nominals
        $nominals = MetaDuesNominals::all('id', 'nominal');
        // dd($users);

        return view('contents.dueses.create', compact('users', 'nominals'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi input untuk memastikan nominal_id dikirimkan
    $request->validate([
        'nominal_id' => 'required|exists:meta_dues_nominals,id',
    ]);

    // Ambil semua user yang memiliki peran 'user' dan sudah memiliki TrashBin, tetapi belum memiliki Dueses
    $users = User::whereHas('roles', function ($query) {
        $query->where('name', 'user');
    })
    ->whereHas('trashBin')
    ->whereDoesntHave('dueses')
    ->with('userData')
    ->get();

    // Ambil nominal dari request
    $nominalId = $request->nominal_id;

    foreach ($users as $user) {
        Dueses::create([
            'user_id' => $user->id,
            'meta_dues_nominal_id' => $nominalId,
            'is_paid' => 0, // Status default, misalnya '0' untuk 'belum dibayar'
        ]);
    }

    return redirect()->route('dueses.index')->with('success', 'Tagihan berhasil di-generate untuk semua user!');
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
        $data['dueses'] = Dueses::find($id);

        // Mengambil semua data pengguna beserta userdata terkait, hanya yang belum memiliki tagihan
        $data['users'] = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })
        ->whereHas('trashBin')
        ->whereDoesntHave('dueses')
        ->with('userData')
        ->get();

        $data['nominals'] = MetaDuesNominals::all();

        $data['formatRupiah'] = function($number) {
            return 'Rp. ' . number_format($number, 0, ',', '.');
        };

        // dd($data);

        return view('contents.dueses.edit', $data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data yang diterima
        $request->validate([
            'user_id' => 'required',
            'nominal_id' => 'required',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);
    
        try {
            // Temukan data dueses berdasarkan ID
            $dueses = Dueses::findOrFail($id);
    
            // Data yang akan diperbarui
            $updateData = [
                'user_id' => $request->input('user_id'),
                'meta_dues_nominal_id' => $request->input('nominal_id'),
                // Tambahkan field lainnya sesuai kebutuhan
            ];
    
            // Perbarui data dueses
            $dueses->update($updateData);
    
            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('dueses.index')->with('success', 'Data berhasil diperbarui.');
    
        } catch (\Exception $e) {
            // Tangani kesalahan
            return redirect()->route('dueses.index')->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {    
            Dueses::find($id)->delete();

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(),]);
        }
    
        return response()->json(['status' => true, 'message' => 'Success Delete Tagihan!',]);
    }
    // public function destroy(string $id)
    // {
    //     try { 
            
    //         Dueses::find($id)->delete();

    //     } catch (\Exception $e) {
    //         return response()->json(['status' => false, 'message' => $e->getMessage(),]);
    //     }
    
    //     return response()->json(['status' => true, 'message' => 'Success Delete Tagihan',]);
    // }

    public function notification(Request $request)
    {
        $userId = $request->id;
        $dues = Dueses::where('user_id', $userId)->with('user', 'metaDuesNominal')->first();
        
        try {
            if ($dues && !$dues->is_paid) {
                $totalInvoice = $dues->metaDuesNominal->nominal;

                // Buat notifikasi untuk user disini
                Helper::pushNotification(
                    type: 'invoice',
                    fcm: $dues->user->fcm_token,
                    title: "Tagihan Bulan Ini",
                    body: "Harap segera melakukan pembayaran bulan ini. Total tagihan: Rp. $totalInvoice",
                    totalInvoice: "$totalInvoice",
                );

                return Helper::successMessage("Notifikasi berhasil dikirim!");
            } else {
                return Helper::badRequestMessage("User tidak ditemukan atau sudah membayar.");
            }
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }


    public function datatable(Request $request)
{
    // Mulai query dengan eager loading relasi yang diperlukan
    $query = Dueses::with('user', 'user.userData', 'metaDuesNominal');

    // Proses filter berdasarkan status pembayaran
    if ($request->has('filter')) {
        $filter = $request->input('filter');
        if ($filter == 'paid') {
            $query->where('is_paid', 1);
        } elseif ($filter == 'unpaid') {
            $query->where('is_paid', 0);
        }
    }

    // Ambil data setelah menerapkan filter
    $data = $query->get();

    return DataTables::of($data)->make();
}

public function exportExcel(Request $request)
{
    $currentDate = Carbon::now('Asia/Jakarta');
    $fileName = 'rekap_tagihan_' . $currentDate->format('F_Y') . '.xlsx';

    // Ekspor data menggunakan nama file yang ditentukan
    return $this->excel->download(new DuesesExport, $fileName);
}

public function updateStatus(Request $request)
{
    $request->validate([
        'id' => 'required|exists:dueses,id',
        'is_paid' => 'required|boolean',
    ]);

    $dues = Dueses::findOrFail($request->id);
    $dues->is_paid = $request->is_paid;
    $dues->save();

    return response()->json(['success' => true]);
}


}
