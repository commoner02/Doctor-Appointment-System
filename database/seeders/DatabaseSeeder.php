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
            ],
            [
                'name' => 'Dr. Fatima Khatun',
                'email' => 'fatima@doctime.com',
                'speciality' => 'Gynecology & Obstetrics',
                'qualifications' => 'MBBS, FCPS (Gynecology)',
                'experience' => 12,
            ],
            [
                'name' => 'Dr. Abdul Karim',
                'email' => 'karim@doctime.com',
                'speciality' => 'Orthopedics',
                'qualifications' => 'MBBS, MS (Orthopedics)',
                'experience' => 10,
            ],
            [
                'name' => 'Dr. Rashida Begum',
                'email' => 'rashida@doctime.com',
                'speciality' => 'Pediatrics',
                'qualifications' => 'MBBS, DCH, FCPS (Pediatrics)',
                'experience' => 8,
            ],
            [
                'name' => 'Dr. Mizanur Rahman',
                'email' => 'mizan@doctime.com',
                'speciality' => 'Internal Medicine',
                'qualifications' => 'MBBS, FCPS (Medicine)',
                'experience' => 20,
            ],
            [
                'name' => 'Dr. Nasreen Akter',
                'email' => 'nasreen@doctime.com',
                'speciality' => 'Dermatology',
                'qualifications' => 'MBBS, DDV, MD (Dermatology)',
                'experience' => 7,
            ],
            [
                'name' => 'Dr. Shahidul Islam',
                'email' => 'shahid@doctime.com',
                'speciality' => 'Neurology',
                'qualifications' => 'MBBS, FCPS (Neurology)',
                'experience' => 14,
            ],
            [
                'name' => 'Dr. Salma Khatun',
                'email' => 'salma@doctime.com',
                'speciality' => 'Ophthalmology',
                'qualifications' => 'MBBS, DO, FCPS (Ophthalmology)',
                'experience' => 9,
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
                'phone' => $user->phone,
                'license_number' => 'BMA-' . rand(10000, 99999),
                'verification_status' => 'verified',
            ]);

            $doctors[] = $doctor;
        }

        // Bangladesh-specific chambers (updated to match migration)
        $chambers_data = [
            // Dr. Rahman (Cardiology)
            [
                'doctor_id' => $doctors[0]->id,
                'name' => 'Square Hospital Heart Center',
                'address' => '18/F, Bir Uttam Qazi Nuruzzaman Sarak, West Panthapath, Dhaka 1205',
                'phone' => '88028144400',
                'fee' => 1500.00,
                'is_active' => true,
                'working_days' => 'Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday',
                'start_time' => '16:00:00',
                'end_time' => '20:00:00',
            ],
            [
                'doctor_id' => $doctors[0]->id,
                'name' => 'Ibn Sina Diagnostic Center',
                'address' => 'House 48, Road 9/A, Dhanmondi, Dhaka 1209',
                'phone' => '88029661991',
                'fee' => 1200.00,
                'is_active' => true,
                'working_days' => 'Friday',
                'start_time' => '14:00:00',
                'end_time' => '18:00:00',
            ],

            // Dr. Fatima (Gynecology)
            [
                'doctor_id' => $doctors[1]->id,
                'name' => 'Dhaka Medical College Hospital',
                'address' => 'Secretariat Road, Ramna, Dhaka 1000',
                'phone' => '88028631167',
                'fee' => 800.00,
                'is_active' => true,
                'working_days' => 'Saturday,Sunday,Monday,Wednesday',
                'start_time' => '14:00:00',
                'end_time' => '18:00:00',
            ],
            [
                'doctor_id' => $doctors[1]->id,
                'name' => 'Birdem General Hospital',
                'address' => '122 Kazi Nazrul Islam Avenue, Dhaka 1000',
                'phone' => '88028616641',
                'fee' => 1000.00,
                'is_active' => true,
                'working_days' => 'Tuesday,Thursday',
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
            ],

            // Dr. Karim (Orthopedics)
            [
                'doctor_id' => $doctors[2]->id,
                'name' => 'National Institute of Orthopedics',
                'address' => 'Sher-E-Bangla Nagar, Dhaka 1207',
                'phone' => '88029181013',
                'fee' => 1200.00,
                'is_active' => true,
                'working_days' => 'Sunday,Monday,Tuesday,Wednesday,Thursday',
                'start_time' => '14:00:00',
                'end_time' => '18:00:00',
            ],
            [
                'doctor_id' => $doctors[2]->id,
                'name' => 'Bone & Joint Hospital',
                'address' => 'Green Road, Panthapath, Dhaka 1205',
                'phone' => '88029661234',
                'fee' => 1500.00,
                'is_active' => true,
                'working_days' => 'Saturday',
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
            ],

            // Dr. Rashida (Pediatrics)
            [
                'doctor_id' => $doctors[3]->id,
                'name' => 'Dhaka Shishu Hospital',
                'address' => 'Sher-E-Bangla Nagar, Dhaka 1207',
                'phone' => '88028118061',
                'fee' => 600.00,
                'is_active' => true,
                'working_days' => 'Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday',
                'start_time' => '14:00:00',
                'end_time' => '18:00:00',
            ],
            [
                'doctor_id' => $doctors[3]->id,
                'name' => 'Apollo Hospitals Dhaka',
                'address' => 'Plot 81, Block E, Bashundhara R/A, Dhaka 1229',
                'phone' => '88028401661',
                'fee' => 1000.00,
                'is_active' => true,
                'working_days' => 'Friday',
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
            ],

            // Dr. Mizan (Internal Medicine)
            [
                'doctor_id' => $doctors[4]->id,
                'name' => 'Bangabandhu Sheikh Mujib Medical University',
                'address' => 'Shahbag, Dhaka 1000',
                'phone' => '88029661064',
                'fee' => 500.00,
                'is_active' => true,
                'working_days' => 'Sunday,Monday,Tuesday,Wednesday,Thursday',
                'start_time' => '14:00:00',
                'end_time' => '18:00:00',
            ],
            [
                'doctor_id' => $doctors[4]->id,
                'name' => 'United Hospital Limited',
                'address' => 'Plot 15, Road 71, Gulshan 2, Dhaka 1212',
                'phone' => '88028836000',
                'fee' => 2000.00,
                'is_active' => true,
                'working_days' => 'Saturday',
                'start_time' => '16:00:00',
                'end_time' => '20:00:00',
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

        // Sample Appointments with afternoon/evening times
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
                    'status' => $status,
                    'payment_status' => $status === 'completed' ? 'paid' : 'pending',
                    'reason' => $this->getRandomMedicalReason(),
                    'notes' => $this->getRandomMedicalNote(),
                ]);
            }
        }
    }

    private function getRandomMedicalReason(): string
    {
        $reasons = [
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

        return $reasons[array_rand($reasons)];
    }

    private function getRandomMedicalNote(): string
    {
        $notes = [
            'Visit again in 3 days for follow-up',
            'Prescribed medication for 7 days, return if symptoms persist',
            'Blood tests advised, come back with reports',
            'Physical therapy recommended, follow-up in 2 weeks',
            'Dietary changes advised, monitor blood pressure daily',
            'Further investigation needed, schedule ultrasound',
            'Patient educated about condition management',
            'Vaccination completed, next dose in 1 month',
            'X-ray advised for further diagnosis',
            'Medication adjusted, monitor side effects',
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
