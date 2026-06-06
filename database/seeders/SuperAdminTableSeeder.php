<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SuperAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $user = User::where('email', 'sabujdas94@gmail.com')->first();

        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Sabuj Das',
                'username' => 'sabujdas94',
                'email' => 'sabujdas94@gmail.com',
                'password' => bcrypt('secrect1234')
            ]);
        }
        Role::firstOrCreate(['name' => "Super Admin"]);
        $user->assignRole("Super Admin");
    }
}
