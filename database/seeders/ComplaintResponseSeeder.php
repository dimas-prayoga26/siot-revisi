<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Database\Seeder;
use App\Models\ComplaintResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ComplaintResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    try {
        DB::beginTransaction();

        // Ambil ID dari pengguna dengan email 'petugas@gmail.com'
        $user = User::where('email', 'petugas@gmail.com')->first();

        if ($user) {
            $userId = $user->id;

            // Ambil semua keluhan kecuali yang memiliki status 'submitted'
            $complaints = Complaint::where('status', '!=', 'submitted')->get();

            foreach ($complaints as $complaint) {
                ComplaintResponse::create([
                    'complaint_id' => $complaint->id,
                    'user_id' => $userId,
                    'desc' => 'Response to complaint ' . $complaint->id,
                    'image' => 'complaint_images/sample_complaint.jpg',
                ]);
            }
        } else {
            echo "User with email 'petugas@gmail.com' not found.";
        }

        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    }
}


}
