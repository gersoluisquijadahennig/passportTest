<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Realm;
use App\Models\UserAdmin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = UserAdmin::factory()->create([
            'name' => 'admin',
            'email' => 'admin@ssbiobio.cl',
            'password' => bcrypt('123123123'),
            'rut' => '263354516',
            'first_name' => 'admin',
            'alias' => 'Admin',
        ]);

        $realm = Realm::create([
            'name' => 'master',
            'description' => 'master realm form ssbiobio',
            'active' => true,
            'slug' => 'master',
        ]);

        $admin->realms()->attach($realm->id);
    }
}
