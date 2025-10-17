<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Chamber;
use App\Models\Appointment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User (verified by default)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hospital.bd',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_verified' => true
        ]);

        // Doctor seeding (Bangladesh)
        $doctors = [
            [
                'email' => 'dr.mrahman@hospital.bd',
                'first_name' => 'Mohammad',
                'last_name' => 'Rahman',
                'speciality' => 'Cardiologist',
                'phone' => '+8801712345678',
                'license_no' => 'BMDC-654321',
                'qualifications' => 'MBBS, FCPS (Cardiology)',
                'chamber' => [
                    'name' => 'Dhanmondi Heart Clinic',
                    'location' => 'House 12, Road 5, Dhanmondi, Dhaka',
                    'phone' => '+8801712345678',
                    'start_time' => '10:00:00',
                    'end_time' => '18:00:00',
                    'visiting_fee' => 1000.00,
                    // MySQL SET accepts comma-separated values
                    'working_days' => 'Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday'
                ]
            ],
            [
                'email' => 'dr.aakter@hospital.bd',
                'first_name' => 'Ayesha',
                'last_name' => 'Akter',
                'speciality' => 'Neurologist',
                'phone' => '+8801811223344',
                'license_no' => 'BMDC-789012',
                'qualifications' => 'MBBS, MD (Neurology)',
                'chamber' => [
                    'name' => 'Chattogram Neuro Care',
                    'location' => 'Agrabad Access Rd, Chattogram',
                    'phone' => '+8801811223344',
                    'start_time' => '16:00:00',
                    'end_time' => '21:00:00',
                    'visiting_fee' => 800.00,
                    'working_days' => 'Saturday,Sunday,Monday,Tuesday,Wednesday'
                ]
            ],
            [
                'email' => 'dr.khossain@hospital.bd',
                'first_name' => 'Kamal',
                'last_name' => 'Hossain',
                'speciality' => 'Dermatologist',
                'phone' => '+8801911556677',
                'license_no' => 'BMDC-112233',
                'qualifications' => 'MBBS, DDV',
                'chamber' => [
                    'name' => 'Sylhet Skin Center',
                    'location' => 'Zindabazar, Sylhet',
                    'phone' => '+8801911556677',
                    'start_time' => '09:30:00',
                    'end_time' => '14:30:00',
                    'visiting_fee' => 700.00,
                    'working_days' => 'Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday'
                ]
            ]
        ];

        $createdDoctors = [];
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

            $chamber = Chamber::create([
                'doctor_id' => $doctor->id,
                'chamber_name' => $doc['chamber']['name'],
                'chamber_location' => $doc['chamber']['location'],
                'phone' => $doc['chamber']['phone'],
                'start_time' => $doc['chamber']['start_time'],
                'end_time' => $doc['chamber']['end_time'],
                'visiting_fee' => $doc['chamber']['visiting_fee'],
                // For MySQL SET, a comma-separated string is fine
                'working_days' => $doc['chamber']['working_days'],
            ]);

            $createdDoctors[] = ['doctor' => $doctor, 'chamber' => $chamber];
        }

        // Patient seeding (Bangladesh, always verified)
        $patients = [
            [
                'email' => 'sabbir.ahmed@example.bd',
                'first_name' => 'Sabbir',
                'last_name' => 'Ahmed',
                'gender' => 'Male',
                'phone' => '+8801799001122',
                'date_of_birth' => '1992-03-11',
                'blood_group' => 'A+',
                'address' => 'Dhanmondi, Dhaka'
            ],
            [
                'email' => 'nusrat.jahan@example.bd',
                'first_name' => 'Nusrat',
                'last_name' => 'Jahan',
                'gender' => 'Female',
                'phone' => '+8801677003344',
                'date_of_birth' => '1988-07-25',
                'blood_group' => 'O+',
                'address' => 'Agrabad, Chattogram'
            ],
            [
                'email' => 'mahmudul.hasan@example.bd',
                'first_name' => 'Mahmudul',
                'last_name' => 'Hasan',
                'gender' => 'Male',
                'phone' => '+8801300556677',
                'date_of_birth' => '1995-12-05',
                'blood_group' => 'B+',
                'address' => 'Zindabazar, Sylhet'
            ]
        ];

        $createdPatients = [];
        foreach ($patients as $pat) {
            $user = User::create([
                'name' => $pat['first_name'] . ' ' . $pat['last_name'],
                'email' => $pat['email'],
                'password' => Hash::make('password'),
                'role' => 'patient',
                'is_verified' => true
            ]);

            $patient = Patient::create([
                'user_id' => $user->id,
                'first_name' => $pat['first_name'],
                'last_name' => $pat['last_name'],
                'gender' => $pat['gender'],
                'phone' => $pat['phone'],
                'date_of_birth' => $pat['date_of_birth'],
                'blood_group' => $pat['blood_group'],
                'address' => $pat['address']
            ]);

            $createdPatients[] = $patient;
        }

        // Sample appointments (dates aligned to working hours)
        if (!empty($createdDoctors) && !empty($createdPatients)) {
            Appointment::create([
                'patient_id' => $createdPatients[0]->id,
                'doctor_id' => $createdDoctors[0]['doctor']->id,
                'chamber_id' => $createdDoctors[0]['chamber']->id,
                'appointment_date' => '2025-10-20 10:30:00',
                'appointment_status' => 'scheduled',
                'payment_status' => 'unpaid',
                'reason' => 'Chest discomfort and shortness of breath',
                'notes' => 'First-time visit'
            ]);

            Appointment::create([
                'patient_id' => $createdPatients[1]->id,
                'doctor_id' => $createdDoctors[1]['doctor']->id,
                'chamber_id' => $createdDoctors[1]['chamber']->id,
                'appointment_date' => '2025-10-21 19:00:00',
                'appointment_status' => 'scheduled',
                'payment_status' => 'paid',
                'reason' => 'Frequent headaches and dizziness',
                'notes' => 'Carry previous MRI reports'
            ]);

            Appointment::create([
                'patient_id' => $createdPatients[2]->id,
                'doctor_id' => $createdDoctors[2]['doctor']->id,
                'chamber_id' => $createdDoctors[2]['chamber']->id,
                'appointment_date' => '2025-10-18 11:15:00',
                'appointment_status' => 'completed',
                'payment_status' => 'paid',
                'reason' => 'Skin rash and itching',   //this is to fill by patient..
                'notes' => 'Prescribed topical ointment' //this is to fillable by doctor..
            ]);
        }
    }
}


/**
 * Database Seeder - Test Credentials
 * 
 * Admin:
 * - Email: admin@hospital.bd | Password: password
 * 
 * Doctors:
 * - Email: dr.mrahman@hospital.bd | Password: password (Cardiologist)
 * - Email: dr.aakter@hospital.bd | Password: password (Neurologist)
 * - Email: dr.khossain@hospital.bd | Password: password (Dermatologist)
 * 
 * Patients:
 * - Email: sabbir.ahmed@example.bd | Password: password
 * - Email: nusrat.jahan@example.bd | Password: password
 * - Email: mahmudul.hasan@example.bd | Password: password
 */