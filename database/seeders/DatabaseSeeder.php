<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // database/seeders/DatabaseSeeder.php

public function run(): void
{
    \App\Models\User::factory(5)->create();

    $this->call([
        RolePermissionSeeder::class,
        BookSeeder::class,
        LendingRecordSeeder::class,
    ]);
}

}
