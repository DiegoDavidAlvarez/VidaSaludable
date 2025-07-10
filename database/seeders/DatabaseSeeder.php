<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Administrador']);

        Permission::create(['name' =>'admin.home.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.dashboard.view'])->syncRoles([$role]); 

        Permission::create(['name' =>'admin.categoria.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.categoria.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.categoria.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.categoria.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.categoria.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.categoria.export-excel'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.supplier.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.supplier.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.supplier.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.supplier.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.supplier.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.supplier.export-excel'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.supplier.consultar-ruc'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.product.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.product.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.product.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.product.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.product.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.product.export-excel'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.purchase.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.purchase.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.purchase.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.purchase.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.purchase.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.purchase.export-excel'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.purchase_detail.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.purchase_detail.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.purchase_detail.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.purchase_detail.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.purchase_detail.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.purchase_detail.export-excel'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.customer.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.customer.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.customer.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.customer.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.customer.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.customer.export-excel'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.customer.consultar-dni'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.sale.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.sale.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.sale.imprimir_boleta'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.sale.get-product'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.sale.get-customer'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.sale_detail.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.sale_detail.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.sale_detail.export-excel'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.notifications.markAsRead'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.notifications.markAllAsRead'])->syncRoles([$role]);

        User::factory()->create([
            'name' => 'Diego David Alvarez Mescco',
            'email' => '72230971@lasalleurubamba.edu.pe',
            'password' => bcrypt('12345678')
        ])->assignRole('Administrador');
    }
}
