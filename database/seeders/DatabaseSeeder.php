<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $projects = Project::factory(10)->create();
        $users    = User::factory(10)->create();

        foreach ($projects as $project) {
            $tasks = Task::factory(10)->create(['project_id' => $project->id]);

            foreach ($users as $number => $user) {
                $tasks[$number]->user_id = $user->id;
                $tasks[$number]->save();
            }
        }
    }
}
