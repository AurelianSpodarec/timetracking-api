<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Timer;
use App\Models\Report;
use App\Models\Project;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'john',
            'password' => bcrypt('password1'),
        ];

        // Create clients, projects, timers, and reports for each user foreach ($users as $userData) {
            $user = User::create($userData);

            // Create clients
            $clients = [
                [
                    'name' => 'Client A',
                    'statue' => true,
                    'user_id' => $user->id,
                ],
                [
                    'name' => 'Client B',
                    'statue' => false,
                    'user_id' => $user->id,
                ],
                // Add more clients as needed
            ];

            foreach ($clients as $clientData) {
                $client = Client::create($clientData);

                // Create projects
                $projects = [
                    [
                        'name' => 'Project 1',
                        'hourly_rate' => 50.00,
                        'daily_rate' => 60.00,
                        'client_id' => $client->id,
                    ],
                    [
                        'name' => 'Project 2',
                        'hourly_rate' => 60.00,
                        'daily_rate' => 60.00,
                        'client_id' => $client->id,
                    ],
                    // Add more projects as needed
                ];

                foreach ($projects as $projectData) {
                    $project = Project::create($projectData);

                    // Create timers
                    $timers = [
                        [
                            'start_time' => now(),
                            'end_time' => now(),
                            'manual_entry' => false,
                            'updated_manually' => false,
                            'user_id' => $user->id,
                            'project_id' => $project->id,
                        ],
                        // Add more timers as needed
                    ];

                    foreach ($timers as $timerData) {
                        Timer::create($timerData);
                    }
                }

                // Create reports
                $reports = [
                    [
                        'name' => 'Report 1',
                        'file_path' => '/path/to/report1.pdf',
                        'user_id' => $user->id,
                        'client_id' => $client->id,
                    ],
                    [
                        'name' => 'Report 2',
                        'file_path' => '/path/to/report2.pdf',
                        'user_id' => $user->id,
                        'client_id' => $client->id,
                    ],
                    // Add more reports as needed
                ];

                foreach ($reports as $reportData) {
                    Report::create($reportData);
                }
            }
        }
    }
