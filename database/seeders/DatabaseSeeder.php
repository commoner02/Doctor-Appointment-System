<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Chamber;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User (verified by default)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_verified' => true
        ]);

        // Doctor seeding
        $doctors = [
            [
                'email' => 'dr.johnsmith@hospital.com',
                'first_name' => 'John',
                'last_name' => 'Smith',
                'speciality' => 'Cardiologist',
                'phone' => '+1-555-0101',
                'license_no' => 'MD12345678',
                'qualifications' => 'MBBS, MD (Cardiology)'
            ],
            [
                'email' => 'dr.janedoe@hospital.com',
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'speciality' => 'Neurologist',
                'phone' => '+1-555-0102',
                'license_no' => 'MD87654321',
                'qualifications' => 'MBBS, MD (Neurology)'
            ]
        ];

        foreach ($doctors as $doc) {
            $user = User::create([
                'name' => $doc['first_name'] . ' ' . $doc['last_name'],
                'email' => $doc['email'],
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'is_verified' => true
            ]);

            $doctor = Doctor::create([
                'user_id' => $user->id,
                'first_name' => $doc['first_name'],
                'last_name' => $doc['last_name'],
                'speciality' => $doc['speciality'],
                'phone' => $doc['phone'],
                'license_no' => $doc['license_no'],
                'qualifications' => $doc['qualifications']
            ]);

            // Create chambers for doctors - working_days as comma-separated string
            Chamber::create([
                'doctor_id' => $doctor->id,
                'chamber_name' => 'Main Chamber',
                'chamber_location' => 'Hospital Building A, Floor 2',
                'phone' => $doc['phone'],
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'working_days' => 'Monday,Tuesday,Wednesday,Thursday,Friday'
            ]);
        }

        // Patient seeding (always verified)
        $patients = [
            [
                'email' => 'patient1@example.com',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'gender' => 'Male',
                'phone' => '1234567890',
                'date_of_birth' => '1990-01-15',
                'blood_group' => 'A+',
                'address' => '123 Main St, City, State'
            ],
            [
                'email' => 'patient2@example.com',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'gender' => 'Female',
                'phone' => '0987654321',
                'date_of_birth' => '1985-05-20',
                'blood_group' => 'B+',
                'address' => '456 Oak Ave, City, State'
            ]
        ];

        foreach ($patients as $pat) {
            $user = User::create([
                'name' => $pat['first_name'] . ' ' . $pat['last_name'],
                'email' => $pat['email'],
                'password' => Hash::make('password'),
                'role' => 'patient',
                'is_verified' => true
            ]);

            Patient::create([
                'user_id' => $user->id,
                'first_name' => $pat['first_name'],
                'last_name' => $pat['last_name'],
                'gender' => $pat['gender'],
                'phone' => $pat['phone'],
                'date_of_birth' => $pat['date_of_birth'],
                'blood_group' => $pat['blood_group'],
                'address' => $pat['address']
            ]);
        }
    }
}