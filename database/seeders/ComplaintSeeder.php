<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    try {
        DB::beginTransaction();
        // Ambil ID dari pengguna dengan email 'masyarakat@gmail.com'
        $user = User::where('email', 'masyarakat@gmail.com')->first();

        if (!$user) {
            $this->command->error('Tidak ditemukan pengguna dengan email masyarakat@gmail.com.');
            return;
        }

        $userId = $user->id;

        $complaints = [
            [
                'user_id' => $userId,
                'desc' => 'Complaint description 1',
                'image' => 'complaint_images/sample_complaint.jpg',
                'status' => 'submitted',
            ],
            [
                'user_id' => $userId,
                'desc' => 'Complaint description 2',
                'image' => 'complaint_images/sample_complaint.jpg',
                'status' => 'needs_validation',
            ],
            [
                'user_id' => $userId,
                'desc' => 'Complaint description 3',
                'image' => 'complaint_images/sample_complaint.jpg',
                'status' => 'on_hold',
            ],
            [
                'user_id' => $userId,
                'desc' => 'Complaint description 4',
                'image' => 'complaint_images/sample_complaint.jpg',
                'status' => 'resolved',
            ],
        ];

        foreach ($complaints as $complaint) {
            Complaint::create($complaint);
        }

        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        echo $th->getMessage();
    }
}


}
