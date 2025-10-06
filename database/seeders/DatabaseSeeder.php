<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create Departments
        $cardiology = Department::create([
            'name' => 'Cardiology',
            'description' => 'Heart related treatments and surgeries.'
        ]);

        $neurology = Department::create([
            'name' => 'Neurology',
            'description' => 'Brain and nervous system treatments.'
        ]);

        $orthopedics = Department::create([
            'name' => 'Orthopedics',
            'description' => 'Musculoskeletal system treatments.'
        ]);

        $pediatrics = Department::create([
            'name' => 'Pediatrics',
            'description' => 'Medical care for infants, children, and adolescents.'
        ]);
        +

        $gynecology = Department::create([
            'name' => 'Gynecology',
            'description' => 'Women\'s reproductive health care.'
        ]);

        // Create Verified Doctor 1 - Cardiologist
        $doctorUser1 = User::create([
            'name' => 'Dr. John Smith',
            'email' => 'dr.johnsmith@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'status' => 'active',
        ]);

        Doctor::create([
            'user_id' => $doctorUser1->id,
            'department_id' => $cardiology->id,
            'first_name' => 'John',
            'last_name' => 'Smith',
            'speciality' => 'Interventional Cardiology',
            'phone' => '+1-555-0101',
            'medical_license' => 'MD12345678',
            'qualifications' => 'MBBS, MD (Cardiology), Fellowship in Interventional Cardiology',
        ]);

        // Create Verified Doctor 2 - Neurologist
        $doctorUser2 = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'dr.sarahjohnson@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'status' => 'active',
        ]);

        Doctor::create([
            'user_id' => $doctorUser2->id,
            'department_id' => $neurology->id,
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'speciality' => 'Clinical Neurology',
            'phone' => '+1-555-0102',
            'medical_license' => 'MD87654321',
            'qualifications' => 'MBBS, MD (Neurology), Board Certified Neurologist',
        ]);

        // Create Verified Doctor 3 - Orthopedic Surgeon
        $doctorUser3 = User::create([
            'name' => 'Dr. Michael Brown',
            'email' => 'dr.michaelbrown@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'status' => 'active',
        ]);

        Doctor::create([
            'user_id' => $doctorUser3->id,
            'department_id' => $orthopedics->id,
            'first_name' => 'Michael',
            'last_name' => 'Brown',
            'speciality' => 'Orthopedic Surgery',
            'phone' => '+1-555-0103',
            'medical_license' => 'MD11223344',
            'qualifications' => 'MBBS, MS (Orthopedics), Fellowship in Joint Replacement Surgery',
        ]);

        // Create Pending Doctor (for testing approval process)
        $pendingDoctorUser = User::create([
            'name' => 'Dr. Emily Davis',
            'email' => 'dr.emilydavis@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'status' => 'pending',
            'registration_data' => json_encode([
                'department_id' => $pediatrics->id,
                'specialty' => 'Pediatric Medicine',
                'medical_license' => 'MD55667788',
                'qualifications' => 'MBBS, MD (Pediatrics), Board Certified Pediatrician',
                'phone' => '+1-555-0104',
                'date_of_birth' => '1985-03-15',
                'address' => '456 Medical Plaza, Healthcare City'
            ])
        ]);

        // Create Sample Patients
        $patientUser1 = User::create([
            'name' => 'Jane Wilson',
            'email' => 'jane.wilson@email.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'status' => 'active',
        ]);

        Patient::create([
            'user_id' => $patientUser1->id,
            'first_name' => 'Jane',
            'last_name' => 'Wilson',
            'gender' => 'female',
            'date_of_birth' => '1990-05-15',
            'phone' => '+1-555-0201',
            'address' => '123 Elm Street, Springfield, IL 62701',
        ]);

        $patientUser2 = User::create([
            'name' => 'Robert Garcia',
            'email' => 'robert.garcia@email.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'status' => 'active',
        ]);

        Patient::create([
            'user_id' => $patientUser2->id,
            'first_name' => 'Robert',
            'last_name' => 'Garcia',
            'gender' => 'male',
            'date_of_birth' => '1985-12-20',
            'phone' => '+1-555-0202',
            'address' => '789 Oak Avenue, Chicago, IL 60601',
        ]);

        $patientUser3 = User::create([
            'name' => 'Maria Rodriguez',
            'email' => 'maria.rodriguez@email.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'status' => 'active',
        ]);

        Patient::create([
            'user_id' => $patientUser3->id,
            'first_name' => 'Maria',
            'last_name' => 'Rodriguez',
            'gender' => 'female',
            'date_of_birth' => '1992-08-10',
            'phone' => '+1-555-0203',
            'address' => '321 Pine Street, Los Angeles, CA 90210',
        ]);

        echo "\n=== Database Seeded Successfully ===\n";
        echo "Admin Login: admin@hospital.com / password\n";
        echo "Doctor Login: dr.johnsmith@hospital.com / password\n";
        echo "Patient Login: jane.wilson@email.com / password\n";
        echo "Pending Doctor: dr.emilydavis@hospital.com (needs admin approval)\n";
        echo "======================================\n";
    }
}
