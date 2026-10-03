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
        // 1. Create sample student user
        $user = User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan.delacruz@mseuf.edu.ph',
            'password' => bcrypt('password'),
        ]);

        // 2. Create sample tuition clearance records
        TuitionClearance::create([
            'user_id' => $user->id,
            'student_id' => '2022-10482',
            'student_name' => 'Juan Dela Cruz',
            'department' => 'College of Computing and Multimedia Studies (CCMS)',
            'tuition_balance' => 0.00,
            'is_cleared' => true,
            'cleared_semester' => '1st Semester 2026-2027',
        ]);

        TuitionClearance::create([
            'student_id' => '2023-99812',
            'student_name' => 'Maria Clara Santos',
            'department' => 'College of Engineering',
            'tuition_balance' => 4500.00,
            'is_cleared' => false,
            'cleared_semester' => '1st Semester 2026-2027',
        ]);

        // 3. Create sample MSEUF events
        $event1 = Event::create([
            'title' => 'MSEUF University Foundation Week 2026: Concert & Grand Festival',
            'slug' => 'mseuf-foundation-week-2026',
            'description' => 'Join the annual celebration of Manuel S. Enverga University Foundation! Featuring live music, cultural showcases, food bazaars, and special guest performers at the MSEUF Gymnasium.',
            'location' => 'MSEUF Gymnasium, Lucena Main Campus',
            'organizer' => 'Supreme Student Council & Office of Student Affairs',
            'category' => 'University Festival',
            'event_date' => '2026-10-15 17:00:00',
            'banner_image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80',
            'total_capacity' => 1500,
            'requires_tuition_clearance' => true,
            'is_featured' => true,
            'status' => 'upcoming',
        ]);

        TicketType::create([
            'event_id' => $event1->id,
            'name' => 'Student Free Pass (Clearance Required)',
            'price' => 0.00,
            'quota' => 1000,
            'remaining' => 1000,
        ]);

        TicketType::create([
            'event_id' => $event1->id,
            'name' => 'VIP Front Stage Pass',
            'price' => 250.00,
            'quota' => 200,
            'remaining' => 200,
        ]);

        $event2 = Event::create([
            'title' => 'CCMS Tech Summit 2026: AI & Cyber-Security Innovations',
            'slug' => 'ccms-tech-summit-2026',
            'description' => 'A premier technology conference hosted by the College of Computing and Multimedia Studies featuring industry experts, live coding workshops, and AI product demos.',
            'location' => 'AEC Little Theater, MSEUF',
            'organizer' => 'College of Computing and Multimedia Studies (CCMS)',
            'category' => 'Academic & Tech',
            'event_date' => '2026-11-05 09:00:00',
            'banner_image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80',
            'total_capacity' => 400,
            'requires_tuition_clearance' => false,
            'is_featured' => true,
            'status' => 'upcoming',
        ]);

        TicketType::create([
            'event_id' => $event2->id,
            'name' => 'General Delegate Pass',
            'price' => 100.00,
            'quota' => 300,
            'remaining' => 300,
        ]);

        $event3 = Event::create([
            'title' => 'Wildcats Inter-College Sports Fest Finals',
            'slug' => 'wildcats-sports-fest-finals',
            'description' => 'Witness the thrilling championship games of the MSEUF Wildcats! Basketball, Volleyball, and Esports finals live action.',
            'location' => 'MSEUF Covered Court',
            'organizer' => 'MSEUF Sports Development Office',
            'category' => 'Sports & Athletics',
            'event_date' => '2026-11-20 13:00:00',
            'banner_image' => 'https://images.unsplash.com/photo-1504450758481-7338eba7524a?auto=format&fit=crop&w=1200&q=80',
            'total_capacity' => 800,
            'requires_tuition_clearance' => true,
            'is_featured' => false,
            'status' => 'upcoming',
        ]);

        TicketType::create([
            'event_id' => $event3->id,
            'name' => 'Wildcat Bleacher Seat',
            'price' => 50.00,
            'quota' => 500,
            'remaining' => 500,
        ]);
    }
}
