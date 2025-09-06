<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        DB::table('tipousuarios')->insert([
            ['tipousu' => 'SuperAdmin'],
            ['tipousu' => 'Empresa'],
            ['tipousu' => 'Cliente'],
        ]);

        DB::table('planes')->insert([
            ['nombre' => 'Gratis', 'precio' => 0, 'duracion_dias' => 30, 'limite_paquetes' => 1],
            ['nombre' => 'Mensual', 'precio' => 50, 'duracion_dias' => 30, 'limite_paquetes' => null],
            ['nombre' => 'Anual', 'precio' => 500, 'duracion_dias' => 365, 'limite_paquetes' => null],
        ]);
    }
}
