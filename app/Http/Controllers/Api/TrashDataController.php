<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Models\TrashBin;
use App\Models\TrashData;
use App\Models\TrashType;
use App\Models\WeightScale;
use Illuminate\Http\Request;
use App\Models\TrashTypeDetail;
use App\Http\Controllers\Controller;

class TrashDataController extends Controller
{
    public function createByDetailType(Request $request, string $trashType, string $uniqueId, string $detailType = null)
{
    $request->validate([
        'pin' => 'required|digits:6',
        'weight' => 'required|numeric',
    ]);

    // Cek apakah detailType diperlukan
    if ($trashType == 'recyclable' && is_null($detailType)) {
        return response()->json(['status' => 'error', 'message' => 'Detail Jenis Sampah diperlukan untuk sampah yang dapat didaur ulang'], 400);
    }

    try {
        // Cari WeightScale berdasarkan uniqueId
        $weightScale = WeightScale::where('unique_id', $uniqueId)->first();

        if (!$weightScale) {
            return response()->json(['status' => 'error', 'message' => 'Timbangan tidak ditemukan'], 404);
        }

        if ($request->pin !== $weightScale->pin) {
            return response()->json(['status' => 'error', 'message' => 'PIN tidak valid'], 400);
        }

        // Cari TrashType berdasarkan trashType
        $trashTypeId = TrashType::where('type', $trashType)->pluck('id')->first();
        if (!$trashTypeId) {
            return response()->json(['status' => 'error', 'message' => 'Jenis Sampah tidak valid'], 400);
        }

        $trashTypeDetailId = null;
        if ($trashType == 'recyclable') {
            // Cari TrashTypeDetail berdasarkan detailType
            $trashTypeDetailId = TrashTypeDetail::where('type', $detailType)->pluck('id')->first();
            if (!$trashTypeDetailId) {
                return response()->json(['status' => 'error', 'message' => 'Detail Jenis Sampah tidak valid'], 400);
            }
        }

        TrashData::create([
            'user_id' => $weightScale->user_id,
            'garbage_officer_id' => $weightScale->user_id,
            'trash_bin_id' => null,
            'weight_scale_id' => $weightScale->id,
            'weight' => $request->weight,
            'trash_type_id' => $trashTypeId,
            'trash_type_detail_id' => $trashTypeDetailId,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data sampah berhasil dibuat'], 200);
    } catch (\Throwable $th) {
        return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
    }
}

public function getDeviceInfo(string $uniqueId)
{
    $weightScale = WeightScale::where('unique_id', $uniqueId)->first();

    if (!$weightScale) {
        return response()->json(['status' => 'error', 'message' => 'Timbangan tidak ditemukan'], 404);
    }

    return response()->json(['status' => 'success', 'data' => $weightScale], 200);
}


    public function resetPin(string $uniqueId)
    {
        try {
            $weightScale = WeightScale::where('unique_id', $uniqueId)->first();

            if (!$weightScale) {
                return Helper::notFoundMessage('Weight Scale not found');
            }

            $newPin = '111111'; // Generate a new 6-digit PIN
            $weightScale->pin = $newPin;
            $weightScale->save();

            return Helper::successMessage('PIN has been reset successfully', ['new_pin' => $newPin]);
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }

    public function changePin(Request $request, string $uniqueId)
    {
        $request->validate([
            'pin_lama' => 'required|digits:6', // Validasi untuk memastikan PIN baru terdiri dari 6 digit
            'pin_baru' => 'required|digits:6', // Validasi untuk memastikan PIN saat ini terdiri dari 6 digit
        ]);

        try {
            $weightScale = WeightScale::where('unique_id', $uniqueId)->first();

            if (!$weightScale) {
                return Helper::notFoundMessage('Weight Scale not found');
            }

            if ($weightScale->pin !== $request->pin_lama) {
                return Helper::badRequestMessage('Invalid current PIN');
            }

            $weightScale->pin = $request->pin_baru;
            $weightScale->save();

            return Helper::successMessage('PIN has been changed successfully');
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }
}
