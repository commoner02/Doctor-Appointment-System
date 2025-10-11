<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Chamber;
use App\Models\Schedule;
use App\Models\Appointment;
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

        $doctor1 = Doctor::create([
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

        $doctor2 = Doctor::create([
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

        $doctor3 = Doctor::create([
            'user_id' => $doctorUser3->id,
            'department_id' => $orthopedics->id,
            'first_name' => 'Michael',
            'last_name' => 'Brown',
            'speciality' => 'Orthopedic Surgery',
            'phone' => '+1-555-0103',
            'medical_license' => 'MD11223344',
            'qualifications' => 'MBBS, MS (Orthopedics), Fellowship in Joint Replacement Surgery',
        ]);

        // Create Pending Doctor
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

        $patient1 = Patient::create([
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

        $patient2 = Patient::create([
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

        $patient3 = Patient::create([
            'user_id' => $patientUser3->id,
            'first_name' => 'Maria',
            'last_name' => 'Rodriguez',
            'gender' => 'female',
            'date_of_birth' => '1992-08-10',
            'phone' => '+1-555-0203',
            'address' => '321 Pine Street, Los Angeles, CA 90210',
        ]);

        // Create Chambers
        $chamber1 = Chamber::create([
            'doctor_id' => $doctor1->id,
            'chamber_name' => 'Cardiology Center - Room 101',
            'chamber_location' => 'Main Building, 1st Floor',
            'phone' => '+1-555-1001',
        ]);

        $chamber2 = Chamber::create([
            'doctor_id' => $doctor2->id,
            'chamber_name' => 'Neurology Clinic - Room 205',
            'chamber_location' => 'Medical Tower, 2nd Floor',
            'phone' => '+1-555-1002',
        ]);

        $chamber3 = Chamber::create([
            'doctor_id' => $doctor3->id,
            'chamber_name' => 'Orthopedic Surgery Suite - Room 301',
            'chamber_location' => 'Surgery Wing, 3rd Floor',
            'phone' => '+1-555-1003',
        ]);

        // Create Schedules
        Schedule::create([
            'doctor_id' => $doctor1->id,
            'chamber_id' => $chamber1->id,
            'day' => 'Monday',
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'slot_duration' => 30,
            'is_available' => true,
        ]);

        Schedule::create([
            'doctor_id' => $doctor1->id,
            'chamber_id' => $chamber1->id,
            'day' => 'Wednesday',
            'start_time' => '10:00:00',
            'end_time' => '16:00:00',
            'slot_duration' => 30,
            'is_available' => true,
        ]);

        Schedule::create([
            'doctor_id' => $doctor2->id,
            'chamber_id' => $chamber2->id,
            'day' => 'Tuesday',
            'start_time' => '08:00:00',
            'end_time' => '14:00:00',
            'slot_duration' => 45,
            'is_available' => true,
        ]);

        Schedule::create([
            'doctor_id' => $doctor2->id,
            'chamber_id' => $chamber2->id,
            'day' => 'Thursday',
            'start_time' => '10:00:00',
            'end_time' => '16:00:00',
            'slot_duration' => 45,
            'is_available' => true,
        ]);

        Schedule::create([
            'doctor_id' => $doctor3->id,
            'chamber_id' => $chamber3->id,
            'day' => 'Monday',
            'start_time' => '14:00:00',
            'end_time' => '18:00:00',
            'slot_duration' => 60,
            'is_available' => true,
        ]);

        // Create Sample Appointments
        Appointment::create([
            'patient_id' => $patient1->id,
            'doctor_id' => $doctor1->id,
            'chamber_id' => $chamber1->id,
            'schedule_id' => 1,
            'appointment_date' => '2025-10-14',
            'status' => 'confirmed',
            'reason' => 'Chest pain and shortness of breath',
        ]);

        Appointment::create([
            'patient_id' => $patient2->id,
            'doctor_id' => $doctor2->id,
            'chamber_id' => $chamber2->id,
            'schedule_id' => 3,
            'appointment_date' => '2025-10-15',
            'status' => 'pending',
            'reason' => 'Recurring headaches',
        ]);

        Appointment::create([
            'patient_id' => $patient3->id,
            'doctor_id' => $doctor3->id,
            'chamber_id' => $chamber3->id,
            'schedule_id' => 5,
            'appointment_date' => '2025-10-14',
            'status' => 'confirmed',
            'reason' => 'Knee pain evaluation',
        ]);

        echo "\n=== Database Seeded Successfully ===\n";
        echo "Admin: admin@hospital.com / password\n";
        echo "Doctor1: dr.johnsmith@hospital.com / password\n";
        echo "Patient1: jane.wilson@email.com / password\n";
        echo "Pending Doctor: dr.emilydavis@hospital.com (needs admin approval)\n";
        echo "=== Sample Data Created ===\n";
        echo "- 5 Departments\n";
        echo "- 3 Active Doctors + 1 Pending Doctor\n";
        echo "- 3 Patients\n";
        echo "- 3 Chambers\n";
        echo "- 5 Schedules\n";
        echo "- 3 Appointments\n";
        echo "======================================\n";
    }
}
