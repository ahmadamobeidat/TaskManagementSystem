<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAndTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $password = Hash::make('password'); // Shared password for all users

        for ($i = 1; $i <= 5; $i++) {
            // Create a user
            $user = User::create([
                'name' => 'user ' . $i,
                'email' => 'user_' . $i . '@task.com',
                'password' => $password,
                'date_of_birth' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Generate a random number of tasks between 11 and 17 for each user
            $taskCount = rand(11, 17);
            for ($j = 1; $j <= $taskCount; $j++) {
                Task::create([
                    'title' => 'Task ' . $j . ' for User ' . $i,
                    'description' => 'This is the description for Task ' . $j . ' for User ' . $i,
                    'status' => ['1', '2', '3'][array_rand(['1', '2', '3'])],
                    'priority' => ['1', '2', '3'][array_rand(['1', '2', '3'])],
                    'user_id' => $user->id,
                    'due_date' => now()->addDays(rand(1, 30)), // Random future date between 1 and 30 days from now
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
