<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Expenses;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(Request $request) {
        try {
            $today = Carbon::now()->toDateString();
    
            $existingExpense = Expenses::where('user_id', $request->user_id)
                                    ->whereDate('date', $today)
                                    ->first();
    
            if ($existingExpense) {
                return Helper::badRequestMessage('Anda hanya bisa melaporkan pengeluaran sekali per hari.');
            }
    
            Expenses::create([
                'user_id' => $request->user_id,
                'nominal' => $request->nominal,
                'date' => $today,
            ]);
    
            return Helper::successMessage('Pengeluaran harian Anda telah dicatat');
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }
    
}
