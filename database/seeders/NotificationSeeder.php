<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    // Ambil pengguna dengan email 'petugas@gmail.com'
    $user = User::where('email', 'petugas@gmail.com')->first();
    
    if (!$user) {
        // Jika tidak ditemukan pengguna dengan email tersebut
        $this->command->error('Tidak ditemukan pengguna dengan email petugas@gmail.com.');
        return;
    }

    // Generate sample data for notifications
    $notifications = [
        [
            'title' => 'New Notification',
            'user_id' => $user->id,
            'content' => 'This is an example of info notification.',
            'type' => 'info',
            'isReaded' => false,
        ],
        [
            'title' => 'Warning Notification',
            'user_id' => $user->id,
            'content' => 'This is an example of warning notification.',
            'type' => 'warning',
            'isReaded' => false,
        ],
        [
            'title' => 'Error Notification',
            'user_id' => $user->id,
            'content' => 'This is an example of error notification.',
            'type' => 'error',
            'isReaded' => false,
        ],
        [
            'title' => 'Success Notification',
            'user_id' => $user->id,
            'content' => 'This is an example of success notification.',
            'type' => 'success',
            'isReaded' => false,
        ],
        [
            'title' => 'New Notification',
            'user_id' => $user->id,
            'content' => 'This is an example of info notification.',
            'type' => 'info',
            'isReaded' => true,
        ],
        [
            'title' => 'Warning Notification',
            'user_id' => $user->id,
            'content' => 'This is an example of warning notification.',
            'type' => 'warning',
            'isReaded' => true,
        ],
        [
            'title' => 'Error Notification',
            'user_id' => $user->id,
            'content' => 'This is an example of error notification.',
            'type' => 'error',
            'isReaded' => true,
        ],
        [
            'title' => 'Success Notification',
            'user_id' => $user->id,
            'content' => 'This is an example of success notification.',
            'type' => 'success',
            'isReaded' => true,
        ],
    ];

    // Insert sample data into notifications table
    foreach ($notifications as $notification) {
        Notification::create([
            'title' => $notification['title'],
            'user_id' => $notification['user_id'],
            'content' => $notification['content'],
            'traash_bin_id' => null, // Set to null for trash_bin_id
            'type' => $notification['type'],
            'isReaded' => $notification['isReaded'],
        ]);
    }
}
}
