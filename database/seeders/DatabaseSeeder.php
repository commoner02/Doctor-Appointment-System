<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //Admin (manually)
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@hospital.com',
            'password' => bcrypt('password'), // Default password
            'role' => 'admin',
        ]);

        //Department 
        Department::create([
            'name' => 'Cardiology',
            'description' => 'Heart related treatments and surgeries.'
        ]);
        Department::create([
            'name' => 'Neurology',
            'description' => 'Brain and nervous system treatments.'
        ]);
        Department::create([
            'name' => 'Orthopedics',
            'description' => 'Musculoskeletal system treatments.'
        ]);

        //Doctor
        $user = User::create([
            'name' => 'Dr. John Doe',
            'email' => 'dr.johndoe@example.com',
            'password' => Hash::make('password'), // Default password
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'department_id' => 1, //Cardiology has ID 1
            'first_name' => 'John',
            'last_name' => 'Doe',
            'speciality' => 'Cardiologist',
            'phone' => '1234567890',
        ]);
        

        //Patient
        $user = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password'), // Default password
            'role' => 'patient',
        ]);

        Patient::create([
            'user_id' => $user->id,
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'gender'=>'Female',
            'date_of_birth'=> '1990-01-01',     
            'phone' => '9876543210',
            'address' => '123 Main St',
        ]);
    }
}
