<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; // Penting: Import model User

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- Permissions ---
        // Permissions Barang
        Permission::firstOrCreate(['name' => 'view products']);
        Permission::firstOrCreate(['name' => 'create products']);
        Permission::firstOrCreate(['name' => 'edit products']);
        Permission::firstOrCreate(['name' => 'delete products']);

        // Permissions Barang Masuk
        Permission::firstOrCreate(['name' => 'view stock-ins']);
        Permission::firstOrCreate(['name' => 'create stock-ins']); // Untuk mencatat barang masuk

        // Permissions Barang Keluar
        Permission::firstOrCreate(['name' => 'view stock-outs']);
        Permission::firstOrCreate(['name' => 'create stock-outs']); // Untuk mencatat barang keluar

        // Permissions Laporan
        Permission::firstOrCreate(['name' => 'view reports']);
        Permission::firstOrCreate(['name' => 'generate pdf reports']); // Izin khusus untuk cetak PDF

        // Permissions Master Data lainnya
        Permission::firstOrCreate(['name' => 'view company profile']);
        Permission::firstOrCreate(['name' => 'edit company profile']); // Jika nanti ada edit profil

        Permission::firstOrCreate(['name' => 'view suppliers']);
        Permission::firstOrCreate(['name' => 'create suppliers']);
        Permission::firstOrCreate(['name' => 'edit suppliers']);
        Permission::firstOrCreate(['name' => 'delete suppliers']);

        Permission::firstOrCreate(['name' => 'view customers']);
        Permission::firstOrCreate(['name' => 'create customers']);
        Permission::firstOrCreate(['name' => 'edit customers']);
        Permission::firstOrCreate(['name' => 'delete customers']);

        // Permissions Role & User Management (Hanya untuk Super Admin)
        Permission::firstOrCreate(['name' => 'manage roles']);
        Permission::firstOrCreate(['name' => 'manage users']);


        // --- Roles ---
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // --- Assign Permissions to Roles ---

        // Super Admin (Bisa melakukan semuanya)
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin (Hanya bisa melihat data dan cetak laporan)
        $adminRole->givePermissionTo([
            'view products',
            'view stock-ins',
            'view stock-outs',
            'view reports',
            'generate pdf reports',
            'view company profile',
            'view suppliers',
            'view customers',
        ]);

        // --- Assign Role to an initial user (Opsional, untuk testing) ---
        // Cari user pertama atau buat baru
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'], // Ganti dengan email super admin Anda
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'), // Ganti dengan password yang aman
            ]
        );
        $user->assignRole('super-admin');

        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Ganti dengan email admin Anda
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'), // Ganti dengan password yang aman
            ]
        );
        $user->assignRole('admin');
    }
}