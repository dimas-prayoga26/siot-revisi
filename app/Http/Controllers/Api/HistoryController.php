<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\TrashData;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(string $id) {
        try {
            $data = TrashData::with('owner', 'owner.userData')->where('user_id', '!=', null)->where('garbage_officer_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
            return Helper::successMessage('Berhasil get data', $data);
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }
}
