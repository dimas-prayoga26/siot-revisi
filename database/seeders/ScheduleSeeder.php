<?php

namespace Database\Seeders;

use App\Models\MetaDate;
use App\Models\Schedule as ModelsSchedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $userId = User::where('email', 'petugas@gmail.com')->pluck('id')->first();

            $startDate = now()->startOfWeek(); // Tanggal tujuh hari yang lalu dari sekarang

            for ($i = 0; $i < 7; $i++) { 
                $metaDates[] = MetaDate::create([
                    'date' => $startDate->format('Y-m-d'),
                ]);

                $startDate->addDay();
            }

            foreach ($metaDates as $key => $value) {
                ModelsSchedule::create([
                    'user_id' => $userId,
                    'meta_date_id' => $value->id,
                    'is_active' => true,
                    'start_time' => now()->format('H:i:s'),
                ]);
            }

            DB::commit();

            // $userId = User::where('email', 'petugas1@gmail.com')->pluck('id')->first();

            // $startDate = now()->startOfWeek();

            // for ($i=0; $i < 7; $i++) { 
            //     $metaDates[] = MetaDate::create([
            //         'date' => $startDate->format('Y-m-d'),
            //     ]);

            //     $startDate->addDay();
            // }

            // foreach ($metaDates as $key => $value) {
            //     ModelsSchedule::create([
            //         'user_id' => $userId,
            //         'meta_date_id' => $value->id,
            //         'is_active' => true,
            //         'start_time' => now()->format('H:i:s'),
            //     ]);
            // }

            // DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
