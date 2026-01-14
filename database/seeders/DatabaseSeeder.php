<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        DB::table('tipousuarios')->insert([
            ['tipousu' => 'SuperAdmin'],
            ['tipousu' => 'Empresa'],
            ['tipousu' => 'Cliente'],
        ]);
        DB::table('personas')->insert([
            [
                'dni' => '71825262',
                'nombres' => 'LUIS FERNANDO',
                'apellidos' => 'SANTILLAN CORNELIO',
                'celular' => '928671412',
            ],
            [
                'dni' => '07763985',
                'nombres' => 'LUCAS',
                'apellidos' => 'SANTILLAN ALIAGA',
                'celular' => null,
            ],
        ]);
        DB::table('empresas')->insert([
            [
                'nameempresa' => 'ANALISIS GEOGRAFICOS S.A.C.',
                'razonsocial' => 'ANALISIS GEOGRAFICOS S.A.C.',
                'ruc' => '20555152559',
                'direccion' => 'CAL. CHINCHON NRO 830 INT. 203 URB. JARDIN',
                'telefono' => '987652341',
            ]
        ]);
        DB::table('reprelegal')->insert([
            [
                'fecha' => now(),
                'fk_idempresas' => '1',
                'fk_idpersonas' => '2',
            ]
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Super Administrador',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345678'),
                'remember_token' => Str::random(10),
                'fk_idpersonas' => null,
                'fk_idtipousuarios' => 1,
                'estado_usu' => '1',
                'intentos_fallidos' => '0',

            ],
            [
                'name' => 'Luis Fernando Santillan Cornelio',
                'email' => 'luisfeversantillancornelio@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('luisfever'),
                'remember_token' => Str::random(10),
                'fk_idpersonas' => 1,
                'fk_idtipousuarios' => 3,
                'estado_usu' => '1',
                'intentos_fallidos' => '0',
            ],
            [
                'name' => 'ANALISIS GEOGRAFICOS S.A.C.',
                'email' => 'lucasaliaga@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('lucasaliaga'),
                'remember_token' => Str::random(10),
                'fk_idpersonas' => 2,
                'fk_idtipousuarios' => 2,
                'estado_usu' => '1',
                'intentos_fallidos' => '0',
            ]
        ]);

        
    }
}
