<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\UserData;
use App\Models\TrashBin;
use App\Models\WeightScale;
use App\Models\TrashType;
use App\Models\TrashData;
use App\Models\TrashTypeDetail;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    try {
        DB::beginTransaction();
        $roles = ['superadmin', 'admin', 'garbage-officer', 'user'];
    
        foreach ($roles as $data) {
            Role::updateOrCreate(['name' => $data]);
        }
    
        // Create Super Admin
        $superAdmin = User::create([
            'username' => 'superAdmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole('superadmin');
    
        UserData::create([
            'user_id' => $superAdmin->id,
            'name' => 'Super Admin',
            'image' => 'profile_images/default.jpg',
        ]);
    
        // Create Admin with specific emails
        $admin1 = User::create([
            'username' => 'adminUser',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole('admin');
    
        UserData::create([
            'user_id' => $admin1->id,
            'name' => 'Admin User',
            'phone_number' => '08380000000',
            'address' => 'Admin Address',
            'image' => 'profile_images/default.jpg',
        ]);
    
        $admin2 = User::create([
            'username' => 'adminUser2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole('admin');
    
        UserData::create([
            'user_id' => $admin2->id,
            'name' => 'Admin User',
            'phone_number' => '08380000000',
            'address' => 'Admin Address',
            'image' => 'profile_images/default.jpg',
        ]);
    
        // Create Garbage Officers with specific emails
        $garbageOfficer1 = User::create([
            'username' => 'garbageOfficer',
            'email' => 'petugas@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole('garbage-officer');
    
        UserData::create([
            'user_id' => $garbageOfficer1->id,
            'name' => 'Garbage Officer',
            'phone_number' => '08381111111',
            'address' => 'Garbage Officer Address',
            'image' => 'profile_images/default.jpg',
        ]);
    
        $garbageOfficer2 = User::create([
            'username' => 'garbageOfficer2',
            'email' => 'petugas2@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole('garbage-officer');
    
        UserData::create([
            'user_id' => $garbageOfficer2->id,
            'name' => 'Garbage Officer',
            'phone_number' => '08381111111',
            'address' => 'Garbage Officer Address',
            'image' => 'profile_images/default.jpg',
        ]);
    
        // Create Users with specific emails
        $user1 = User::create([
            'username' => 'romiSatria',
            'email' => 'masyarakat@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole('user');
    
        UserData::create([
            'user_id' => $user1->id,
            'name' => 'Romi Satria',
            'phone_number' => '08382222222',
            'address' => 'Regular User Address',
            'image' => 'profile_images/default.jpg',
        ]);
    
        $user2 = User::create([
            'username' => 'sriDharwiyanti',
            'email' => 'masyarakat2@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole('user');
    
        UserData::create([
            'user_id' => $user2->id,
            'name' => 'Sri Dharwiyanti',
            'phone_number' => '08382222222',
            'address' => 'Regular User Address',
            'image' => 'profile_images/default.jpg',
        ]);
    
        // Generate random users
        $admins = [];
        $masyarakats = [];
        $petugases = [];
    
        $firstNames = [
            'Adi', 'Budi', 'Cici', 'Dedi', 'Eka', 'Feri', 'Gita', 'Hadi', 'Ika', 'Joko',
            'Kiki', 'Lia', 'Mira', 'Nana', 'Oni', 'Putu', 'Rina', 'Sari', 'Tini', 'Umi',
            'Vira', 'Wawan', 'Xenia', 'Yanto', 'Zara'
        ];
    
        $lastNames = [
            'Santoso', 'Wijaya', 'Setiawan', 'Kurniawan', 'Nugroho', 'Suryono', 'Lestari', 'Pratama',
            'Saputra', 'Wardana', 'Hidayat', 'Prayoga', 'Ningsih', 'Sutanto', 'Rahmawati', 'Sari', 'Ayu',
            'Utami', 'Fadilah', 'Putri'
        ];
    
        for ($i = 1; $i <= 10; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;
            $username = strtolower($firstName) . strtolower($lastName) . $i;
            $email = strtolower($firstName) . strtolower($lastName) . $i . '@gmail.com';
    
            $admins[] = [
                'username' => $username,
                'email' => $email,
                'password' => bcrypt('password'),
                'name' => $fullName,
            ];
    
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;
            $username = strtolower($firstName) . strtolower($lastName) . $i;
            $email = strtolower($firstName) . strtolower($lastName) . $i . '@gmail.com';
    
            $masyarakats[] = [
                'username' => $username,
                'email' => $email,
                'password' => bcrypt('password'),
                'name' => $fullName,
            ];
    
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;
            $username = strtolower($firstName) . strtolower($lastName) . $i;
            $email = strtolower($firstName) . strtolower($lastName) . $i . '@gmail.com';
    
            $petugases[] = [
                'username' => $username,
                'email' => $email,
                'password' => bcrypt('password'),
                'name' => $fullName,
            ];
        }
    
        $userAdmin = [];
        $userMasyarakat = [];
        $userPetugas = [];
    
        foreach ($admins as $data) {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
            ])->assignRole('admin');
    
            UserData::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'phone_number' => '083824648361',
                'address' => 'Desa Kedokan gabus',
                'image' => 'profile_images/default.jpg',
            ]);
    
            $userAdmin[] = $user;
        }
    
        foreach ($masyarakats as $data) {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
            ])->assignRole('user');
    
            UserData::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'phone_number' => '08389171263',
                'address' => 'Desa Leuwigede, kec. Jatibarang, kab. Indramayu',
                'image' => 'profile_images/default.jpg',
            ]);
    
            $userMasyarakat[] = $user;
        }
    
        foreach ($petugases as $data) {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
            ])->assignRole('garbage-officer');
    
            UserData::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'phone_number' => '0838912388921',
                'address' => 'Desa Leuwigede, kec. Widasai, kab. Indramayu',
                'image' => 'profile_images/default.jpg',
            ]);
    
            $userPetugas[] = $user;
            array_push($userPetugas, $garbageOfficer1, $garbageOfficer2);
        }
    
        $latLong = [
            ['latitude' => -6.4329355614169295, 'longitude' => 108.2894227172398],
            ['latitude' => -6.428067600218921, 'longitude' => 108.2889782930509],
            ['latitude' => -6.431000, 'longitude' => 108.289000],
            ['latitude' => -6.433000, 'longitude' => 108.288000],
            ['latitude' => -6.430500, 'longitude' => 108.287500],
            ['latitude' => -6.429500, 'longitude' => 108.290500],
            ['latitude' => -6.432000, 'longitude' => 108.291000],
            ['latitude' => -6.431500, 'longitude' => 108.289500],
            ['latitude' => -6.428500, 'longitude' => 108.288500],
            ['latitude' => -6.429000, 'longitude' => 108.289000],
        ];
    
        foreach ($userMasyarakat as $index => $data) {
            TrashBin::updateOrCreate([
                'user_id' => $data->id,
                'unique_id' => '0123980' . $index,
                'capacity' => 5,
                'maximum_height_trash_bin' => 100,
                'status' => 50,
                'is_active' => true,
            ] + $latLong[$index % count($latLong)]);
        }
    
        foreach ($userPetugas as $index => $data) {
            WeightScale::updateOrCreate([
                'user_id' => $data->id,
                'unique_id' => '012355' . $index,
                'name' => 'Name_' . $index,
                'pin' => '123456',
            ]);
        }
    
        $metaTrashType = [
            ['type' => 'recyclable'],
            ['type' => 'organic'],
            ['type' => 'anorganic'],
            ['type' => 'all'],
        ];
        
        foreach ($metaTrashType as $data) {
            TrashType::updateOrCreate($data);
        }
        
        $metaTrashTypeDetail = [
            ['type' => 'kardus'],
            ['type' => 'kaca'],
            ['type' => 'plastic'],
        ];
        
        foreach ($metaTrashTypeDetail as $data) {
            TrashTypeDetail::updateOrCreate($data);
        }
        
        $startDate = Carbon::parse('2023-01-01', 'Asia/Jakarta');
        $endDate = Carbon::now('Asia/Jakarta');
        
        $trashBins = TrashBin::all();
        $weightScales = WeightScale::all();
        $trashTypes = TrashType::all();
        $trashTypeDetails = TrashTypeDetail::all();
        
        foreach ($userMasyarakat as $i => $user) {
            $date = $startDate->copy();
            while ($date->lte($endDate)) {
                $trashBin = $trashBins->where('user_id', $user->id)->first();
                $weightScale = $weightScales->where('user_id', $userPetugas[$i % count($userPetugas)]->id)->first();
        
                // Generate data for a random number of entries per day (e.g., between 1 and 3)
                $numEntries = mt_rand(1, 3);
                $weights = [
                    'organic' => 0,
                    'anorganic' => 0,
                    'recyclable' => 0,
                ];
        
                for ($j = 0; $j < $numEntries; $j++) {
                    // Randomly pick a trash type for this entry
                    $trashTypeObj = $trashTypes->whereIn('type', ['organic', 'anorganic', 'recyclable'])->random();
                    $trashTypeDetailObj = null;
        
                    if ($trashTypeObj->type == 'recyclable') {
                        $trashTypeDetailObj = $trashTypeDetails->random();
                    }
        
                    $weight = mt_rand(100, 500) / 100; // Generate weight between 1.00 and 5.00
        
                    // Add weight to the corresponding type
                    $weights[$trashTypeObj->type] += $weight;
        
                    TrashData::create([
                        'user_id' => $user->id,
                        'garbage_officer_id' => $userPetugas[$i % count($userPetugas)]->id,
                        'trash_bin_id' => $trashBin->id,
                        'weight_scale_id' => $weightScale->id,
                        'weight' => $weight,
                        'trash_type_id' => $trashTypeObj->id,
                        'trash_type_detail_id' => $trashTypeDetailObj ? $trashTypeDetailObj->id : null,
                        'created_at' => $date->copy()->setTimezone('Asia/Jakarta'),
                        'updated_at' => $date->copy()->setTimezone('Asia/Jakarta'),
                    ]);
                }
        
                // Generate a random entry for 'all' trash type that is not included in the other types
                $allWeight = mt_rand(50, 300) / 100; // Generate weight between 0.50 and 3.00
        
                TrashData::create([
                    'user_id' => $user->id,
                    'garbage_officer_id' => $userPetugas[$i % count($userPetugas)]->id,
                    'trash_bin_id' => $trashBin->id,
                    'weight_scale_id' => $weightScale->id,
                    'weight' => $allWeight,
                    'trash_type_id' => $trashTypes->where('type', 'all')->first()->id,
                    'trash_type_detail_id' => null,
                    'created_at' => $date->copy()->setTimezone('Asia/Jakarta'),
                    'updated_at' => $date->copy()->setTimezone('Asia/Jakarta'),
                ]);
        
                $date->addDay();
            }
        }        
    
        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        echo $e->getMessage();
    }
}


}