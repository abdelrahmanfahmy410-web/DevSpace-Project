<?php
///
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin role if it doesn't exist
        $roleId = DB::table('roles')->where('name', 'admin')->value('id');

        if (!$roleId) {
            $roleId = DB::table('roles')->insertGetId([
                'name'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create admin user if doesn't exist
        $user = User::updateOrCreate(
            ['email' => 'admin@devspace.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Assign role via pivot
        DB::table('user_roles')->updateOrInsert(
            ['user_id' => $user->id, 'role_id' => $roleId],
            ['created_at' => now(), 'updated_at' => now()]
        );
    }
}