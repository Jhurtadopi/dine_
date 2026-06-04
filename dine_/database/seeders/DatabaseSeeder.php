<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Role;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(
            ['name' => Role::ADMINISTRATOR],
            ['description' => 'Gestiona mesas, platos, categorías y QR.']
        );

        $waiterRole = Role::firstOrCreate(
            ['name' => Role::WAITER],
            ['description' => 'Consulta el mapa visual de mesas.']
        );

        User::firstOrCreate(
            ['email' => 'admin@dine.test'],
            [
                'name' => 'Administrador Dine',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'mesero@dine.test'],
            [
                'name' => 'Mesero Dine',
                'password' => Hash::make('password'),
                'role_id' => $waiterRole->id,
                'active' => true,
            ]
        );

        $categories = collect([
            ['name' => 'Entradas', 'description' => 'Platos ligeros para iniciar.'],
            ['name' => 'Fuertes', 'description' => 'Platos principales del restaurante.'],
            ['name' => 'Bebidas', 'description' => 'Bebidas frías y calientes.'],
        ])->map(fn ($data) => Category::firstOrCreate(['name' => $data['name']], $data));

        $entrada = $categories->firstWhere('name', 'Entradas');
        $fuertes = $categories->firstWhere('name', 'Fuertes');
        $bebidas = $categories->firstWhere('name', 'Bebidas');

        $dishes = [
            ['name' => 'Bruschetta Dine', 'description' => 'Pan artesanal con tomate, albahaca y aceite de oliva.', 'price' => 18000, 'category_id' => $entrada->id, 'available' => true],
            ['name' => 'Pasta Carbonara', 'description' => 'Pasta cremosa con tocineta y queso parmesano.', 'price' => 34000, 'category_id' => $fuertes->id, 'available' => true],
            ['name' => 'Salmón Teriyaki', 'description' => 'Salmón glaseado con vegetales salteados.', 'price' => 52000, 'category_id' => $fuertes->id, 'available' => true],
            ['name' => 'Limonada Natural', 'description' => 'Limonada fresca preparada al momento.', 'price' => 9000, 'category_id' => $bebidas->id, 'available' => true],
            ['name' => 'Risotto de Hongos', 'description' => 'Arroz cremoso con mezcla de hongos.', 'price' => 39000, 'category_id' => $fuertes->id, 'available' => false],
        ];

        foreach ($dishes as $dish) {
            Dish::firstOrCreate(['name' => $dish['name']], $dish);
        }

        foreach ([
            ['number' => 1, 'capacity' => 2, 'status' => Table::STATUS_AVAILABLE],
            ['number' => 2, 'capacity' => 4, 'status' => Table::STATUS_AVAILABLE],
            ['number' => 3, 'capacity' => 4, 'status' => Table::STATUS_OCCUPIED],
            ['number' => 4, 'capacity' => 6, 'status' => Table::STATUS_PENDING_PAYMENT],
        ] as $table) {
            Table::firstOrCreate(
                ['number' => $table['number']],
                $table + ['qr_token' => (string) Str::uuid()]
            );
        }
    }
}
