<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Chamber;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@doctime.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+8801711000000',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Sample Doctors with Bangladesh-specific data
        $doctors_data = [
            [
                'name' => 'Dr. Mohammad Rahman',
                'email' => 'rahman@doctime.com',
                'speciality' => 'Cardiology',
                'qualifications' => 'MBBS, MD (Cardiology), FRCP',
                'experience' => 15,
                'bio' => 'Specialist in heart diseases and cardiac surgery with 15 years of experience.',
            ],
            [
                'name' => 'Dr. Fatima Khatun',
                'email' => 'fatima@doctime.com',
                'speciality' => 'Gynecology & Obstetrics',
                'qualifications' => 'MBBS, FCPS (Gynecology)',
                'experience' => 12,
                'bio' => 'Women\'s health specialist with expertise in pregnancy and reproductive health.',
            ],
            [
                'name' => 'Dr. Abdul Karim',
                'email' => 'karim@doctime.com',
                'speciality' => 'Orthopedics',
                'qualifications' => 'MBBS, MS (Orthopedics)',
                'experience' => 10,
                'bio' => 'Bone and joint specialist, expert in fracture treatment and joint replacement.',
            ],
            [
                'name' => 'Dr. Rashida Begum',
                'email' => 'rashida@doctime.com',
                'speciality' => 'Pediatrics',
                'qualifications' => 'MBBS, DCH, FCPS (Pediatrics)',
                'experience' => 8,
                'bio' => 'Child specialist with expertise in newborn care and child development.',
            ],
            [
                'name' => 'Dr. Mizanur Rahman',
                'email' => 'mizan@doctime.com',
                'speciality' => 'Internal Medicine',
                'qualifications' => 'MBBS, FCPS (Medicine)',
                'experience' => 20,
                'bio' => 'General physician specializing in diabetes, hypertension, and chronic diseases.',
            ],
            [
                'name' => 'Dr. Nasreen Akter',
                'email' => 'nasreen@doctime.com',
                'speciality' => 'Dermatology',
                'qualifications' => 'MBBS, DDV, MD (Dermatology)',
                'experience' => 7,
                'bio' => 'Skin specialist treating acne, eczema, psoriasis, and cosmetic procedures.',
            ],
            [
                'name' => 'Dr. Shahidul Islam',
                'email' => 'shahid@doctime.com',
                'speciality' => 'Neurology',
                'qualifications' => 'MBBS, FCPS (Neurology)',
                'experience' => 14,
                'bio' => 'Brain and nervous system specialist treating stroke, epilepsy, and headaches.',
            ],
            [
                'name' => 'Dr. Salma Khatun',
                'email' => 'salma@doctime.com',
                'speciality' => 'Ophthalmology',
                'qualifications' => 'MBBS, DO, FCPS (Ophthalmology)',
                'experience' => 9,
                'bio' => 'Eye specialist performing cataract surgery and treating eye diseases.',
            ]
        ];

        $doctors = [];
        foreach ($doctors_data as $doctor_data) {
            $user = User::create([
                'name' => $doctor_data['name'],
                'email' => $doctor_data['email'],
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'phone' => '+88017' . rand(10000000, 99999999),
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            $doctor = Doctor::create([
                'user_id' => $user->id,
                'speciality' => $doctor_data['speciality'],
                'qualifications' => $doctor_data['qualifications'],
                'experience' => $doctor_data['experience'],
                'bio' => $doctor_data['bio'],
                'phone' => $user->phone,
                'license_number' => 'BMA-' . rand(10000, 99999),
                'verification_status' => 'verified',
            ]);

            $doctors[] = $doctor;
        }

        // Bangladesh-specific chambers
        $chambers_data = [
            // Dr. Rahman (Cardiology)
            [
                'doctor_id' => $doctors[0]->id,
                'name' => 'Square Hospital Heart Center',
                'address' => '18/F, Bir Uttam Qazi Nuruzzaman Sarak, West Panthapath, Dhaka 1205',
                'phone' => '+88028144400',
                'visiting_hours' => 'Sat-Thu: 4PM-8PM',
                'fee' => 1500,
            ],
            [
                'doctor_id' => $doctors[0]->id,
                'name' => 'Ibn Sina Diagnostic Center',
                'address' => 'House 48, Road 9/A, Dhanmondi, Dhaka 1209',
                'phone' => '+88029661991',
                'visiting_hours' => 'Fri: 10AM-2PM',
                'fee' => 1200,
            ],

            // Dr. Fatima (Gynecology)
            [
                'doctor_id' => $doctors[1]->id,
                'name' => 'Dhaka Medical College Hospital',
                'address' => 'Secretariat Road, Ramna, Dhaka 1000',
                'phone' => '+8808631167',
                'visiting_hours' => 'Sat-Wed: 9AM-1PM',
                'fee' => 800,
            ],
            [
                'doctor_id' => $doctors[1]->id,
                'name' => 'Birdem General Hospital',
                'address' => '122 Kazi Nazrul Islam Avenue, Dhaka 1000',
                'phone' => '+88028616641',
                'visiting_hours' => 'Thu: 2PM-6PM',
                'fee' => 1000,
            ],

            // Dr. Karim (Orthopedics)
            [
                'doctor_id' => $doctors[2]->id,
                'name' => 'National Institute of Orthopedics',
                'address' => 'Sher-E-Bangla Nagar, Dhaka 1207',
                'phone' => '+88029181013',
                'visiting_hours' => 'Sun-Thu: 10AM-2PM',
                'fee' => 1200,
            ],
            [
                'doctor_id' => $doctors[2]->id,
                'name' => 'Bone & Joint Hospital',
                'address' => 'Green Road, Panthapath, Dhaka 1205',
                'phone' => '+88029661234',
                'visiting_hours' => 'Sat: 3PM-7PM',
                'fee' => 1500,
            ],

            // Dr. Rashida (Pediatrics)
            [
                'doctor_id' => $doctors[3]->id,
                'name' => 'Dhaka Shishu Hospital',
                'address' => 'Sher-E-Bangla Nagar, Dhaka 1207',
                'phone' => '+88028118061',
                'visiting_hours' => 'Sat-Thu: 8AM-12PM',
                'fee' => 600,
            ],
            [
                'doctor_id' => $doctors[3]->id,
                'name' => 'Apollo Hospitals Dhaka',
                'address' => 'Plot 81, Block E, Bashundhara R/A, Dhaka 1229',
                'phone' => '+88028401661',
                'visiting_hours' => 'Fri: 2PM-6PM',
                'fee' => 1000,
            ],

            // Dr. Mizan (Internal Medicine)
            [
                'doctor_id' => $doctors[4]->id,
                'name' => 'Bangabandhu Sheikh Mujib Medical University',
                'address' => 'Shahbag, Dhaka 1000',
                'phone' => '+88029661064',
                'visiting_hours' => 'Sun-Thu: 9AM-1PM',
                'fee' => 500,
            ],
            [
                'doctor_id' => $doctors[4]->id,
                'name' => 'United Hospital Limited',
                'address' => 'Plot 15, Road 71, Gulshan 2, Dhaka 1212',
                'phone' => '+88028836000',
                'visiting_hours' => 'Sat: 4PM-8PM',
                'fee' => 2000,
            ],
        ];

        foreach ($chambers_data as $chamber_data) {
            Chamber::create($chamber_data);
        }

        // Sample Patients
        $patients_data = [
            [
                'name' => 'Md. Alamgir Hossain',
                'email' => 'alamgir@example.com',
                'phone' => '+8801911123456',
                'address' => 'House 25, Road 5, Dhanmondi, Dhaka',
                'blood_group' => 'B+',
            ],
            [
                'name' => 'Fatema Khatun',
                'email' => 'fatema@example.com',
                'phone' => '+8801711234567',
                'address' => 'Flat 3B, Building 12, Uttara Sector 7, Dhaka',
                'blood_group' => 'O+',
            ],
            [
                'name' => 'Karim Ahmed',
                'email' => 'karim@example.com',
                'phone' => '+8801811345678',
                'address' => 'Village: Sreepur, Thana: Savar, Dhaka',
                'blood_group' => 'A+',
            ],
            [
                'name' => 'Rashida Begum',
                'email' => 'rashida@example.com',
                'phone' => '+8801611456789',
                'address' => 'House 45, Mirpur 10, Dhaka',
                'blood_group' => 'AB+',
            ],
            [
                'name' => 'Mohammad Ali',
                'email' => 'ali@example.com',
                'phone' => '+8801511567890',
                'address' => 'Holding 234, Ward 15, Chittagong City',
                'blood_group' => 'O-',
            ],
        ];

        $patients = [];
        foreach ($patients_data as $patient_data) {
            $user = User::create([
                'name' => $patient_data['name'],
                'email' => $patient_data['email'],
                'password' => Hash::make('password'),
                'role' => 'patient',
                'phone' => $patient_data['phone'],
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            $patient = Patient::create([
                'user_id' => $user->id,
                'phone' => $patient_data['phone'],
                'address' => $patient_data['address'],
                'blood_group' => $patient_data['blood_group'],
                'date_of_birth' => Carbon::now()->subYears(rand(25, 65))->format('Y-m-d'),
                'gender' => rand(0, 1) ? 'male' : 'female',
            ]);

            $patients[] = $patient;
        }

        // Sample Appointments
        $chambers = Chamber::all();

        foreach ($patients as $index => $patient) {
            // Create 2-3 appointments per patient
            for ($i = 0; $i < rand(2, 4); $i++) {
                $chamber = $chambers->random();
                $doctor = $chamber->doctor;

                $appointmentDate = Carbon::now()->addDays(rand(-30, 30));
                $status = ['scheduled', 'completed', 'cancelled'][rand(0, 2)];

                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'chamber_id' => $chamber->id,
                    'appointment_date' => $appointmentDate->format('Y-m-d'),
                    'appointment_time' => ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'][rand(0, 5)] . ':00',
                    'status' => $status,
                    'fee' => $chamber->fee,
                    'payment_status' => $status === 'completed' ? 'paid' : 'pending',
                    'notes' => $this->getRandomMedicalNote(),
                ]);
            }
        }
    }

    private function getRandomMedicalNote(): string
    {
        $notes = [
            'Chest pain and shortness of breath for 3 days',
            'Fever and headache since yesterday',
            'Regular checkup for diabetes',
            'Back pain after lifting heavy objects',
            'Skin rash on arms and legs',
            'Eye irritation and redness',
            'Pregnancy checkup - 12 weeks',
            'Child vaccination - MMR',
            'High blood pressure monitoring',
            'Joint pain in knees',
        ];

        return $notes[array_rand($notes)];
    }
}


// # DocTime Healthcare Management System - Login Credentials

// ## ADMIN ACCESS
// admin@doctime.com / password
// # Full system access - manage users, verify doctors, platform oversight

// ## DOCTOR ACCOUNTS (All password: password)
// rahman@doctime.com     # Dr. Mohammad Rahman - Cardiology (Square Hospital, Ibn Sina)
// fatima@doctime.com     # Dr. Fatima Khatun - Gynecology (DMCH, Birdem)
// karim@doctime.com      # Dr. Abdul Karim - Orthopedics (NIOR, Bone Hospital)
// rashida@doctime.com    # Dr. Rashida Begum - Pediatrics (Shishu Hospital, Apollo)
// mizan@doctime.com      # Dr. Mizanur Rahman - Internal Medicine (BSMMU, United)
// nasreen@doctime.com    # Dr. Nasreen Akter - Dermatology
// shahid@doctime.com     # Dr. Shahidul Islam - Neurology
// salma@doctime.com      # Dr. Salma Khatun - Ophthalmology

// ## PATIENT ACCOUNTS (All password: password)
// alamgir@example.com    # Md. Alamgir Hossain - Dhanmondi, B+
// fatema@example.com     # Fatema Khatun - Uttara, O+
// karim@example.com      # Karim Ahmed - Savar, A+
// rashida@example.com    # Rashida Begum - Mirpur, AB+
// ali@example.com        # Mohammad Ali - Chittagong, O-
