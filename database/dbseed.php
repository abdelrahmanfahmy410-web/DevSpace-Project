<?php
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Role::create(['name' => 'developer']);
        Role::create(['name' => 'investor']);
        Role::create(['name' => 'mentor']);

    }
}
