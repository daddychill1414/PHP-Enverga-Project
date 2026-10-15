<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\TuitionClearance;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or update Default Administrator
        User::updateOrCreate(
            ['email' => 'admin@mseuf.edu.ph'],
            [
                'name' => 'MSEUF Administrator',
                'password' => bcrypt('enverga2026'),
                'is_admin' => true,
            ]
        );

        // 2. Realistic MSEUF Student Tuition Clearance Records (Format: A20-30518)
        // User requested: mock data ONLY for tuition fees because external student records cannot be pulled
        $students = [
            [
                'student_id' => 'A20-30518',
                'student_name' => 'Ranie C. Enverga',
                'department' => 'College of Computing and Multimedia Studies (CCMS)',
                'tuition_balance' => 0.00,
                'is_cleared' => true,
                'cleared_semester' => '1st Semester 2026-2027',
            ],
            [
                'student_id' => 'A21-10492',
                'student_name' => 'Juan Miguel Dela Cruz',
                'department' => 'College of Engineering',
                'tuition_balance' => 0.00,
                'is_cleared' => true,
                'cleared_semester' => '1st Semester 2026-2027',
            ],
            [
                'student_id' => 'A22-20831',
                'student_name' => 'Maria Sophia Santos',
                'department' => 'College of Business and Accountancy (CBA)',
                'tuition_balance' => 4850.00,
                'is_cleared' => false,
                'cleared_semester' => '1st Semester 2026-2027',
            ],
            [
                'student_id' => 'A23-40119',
                'student_name' => 'Christian Mark Perez',
                'department' => 'College of Education, Arts and Sciences (CEAS)',
                'tuition_balance' => 0.00,
                'is_cleared' => true,
                'cleared_semester' => '1st Semester 2026-2027',
            ],
            [
                'student_id' => 'A24-50220',
                'student_name' => 'Alyssa Nicole Reyes',
                'department' => 'College of Nursing and Allied Health Sciences',
                'tuition_balance' => 8200.00,
                'is_cleared' => false,
                'cleared_semester' => '1st Semester 2026-2027',
            ],
        ];

        foreach ($students as $student) {
            TuitionClearance::updateOrCreate(
                ['student_id' => $student['student_id']],
                $student
            );
        }
    }
}
