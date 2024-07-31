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
    public function createByDetailType(Request $request, string $trashType, string $detailType = null, string $uniqueId)
    {
        $request->validate([
            'pin' => 'required|digits:6',
            'weight' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        try {
            // Cari WeightScale berdasarkan uniqueId
            $weightScale = WeightScale::where('unique_id', $uniqueId)->first();

            if (!$weightScale) {
                return response()->json(['status' => 'error', 'message' => 'Weight Scale not found'], 404);
            }

            if ($request->pin !== $weightScale->pin) {
                return response()->json(['status' => 'error', 'message' => 'Invalid PIN'], 400);
            }

            // Perbarui latitude dan longitude pada WeightScale
            $weightScale->latitude = $request->latitude;
            $weightScale->longitude = $request->longitude;
            $weightScale->save();

            // Cari TrashType berdasarkan trashType
            $trashTypeId = TrashType::where('type', $trashType)->pluck('id')->first();
            if (!$trashTypeId) {
                return response()->json(['status' => 'error', 'message' => 'Invalid Trash Type'], 400);
            }

            $trashTypeDetailId = null;
            if ($trashType == 'recyclable') {
                // Jika tipe sampah recyclable, detail tipe sampah harus ada
                if (!$detailType) {
                    return response()->json(['status' => 'error', 'message' => 'Detail Trash Type is required for recyclable trash'], 400);
                }

                // Cari TrashTypeDetail berdasarkan detailType
                $trashTypeDetailId = TrashTypeDetail::where('type', $detailType)->pluck('id')->first();
                if (!$trashTypeDetailId) {
                    return response()->json(['status' => 'error', 'message' => 'Invalid Trash Type Detail'], 400);
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

            return response()->json(['status' => 'success', 'message' => 'Trash data created successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function getDeviceInfo(string $uniqueId)
    {
        try {
            $weightScale = WeightScale::where('unique_id', $uniqueId)->first();

            if (!$weightScale) {
                return Helper::notFoundMessage('Weight Scale not found');
            }

            $deviceInfo = [
                'id' => $weightScale->id,
                'user_id' => $weightScale->user_id,
                'unique_id' => $weightScale->unique_id,
                'name' => $weightScale->name,
                'pin' => $weightScale->pin,
                'latitude' => $weightScale->latitude,
                'longitude' => $weightScale->longitude,
            ];

            return Helper::successMessage('Device information retrieved successfully', $deviceInfo);
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
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
