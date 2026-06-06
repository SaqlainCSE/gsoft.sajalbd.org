<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $branchSuperAdmin = Role::firstOrCreate(['name' => Role::BRANCH_SUPER_ADMIN]);

        $modules = Module::firstOrCreate(
            ['name' => 'Admin Dashboard']
        );

        Permission::firstOrCreate(['name' => 'Access Admin Dashboard', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Access POS', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit Sell', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Access Booking', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit Booking', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Delete Booking', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Access Clients', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit Client', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Delete Client', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Access Products', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Add Product', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit Product', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Delete Product', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Access Stock', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Add Stock', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Access Sales Entry', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Access Sale Settings', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Due Transaction List', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Add Due Transaction', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit Due Transaction', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Delete Due Transaction', 'module_id' => $modules->id]);

        Permission::firstOrCreate(['name' => 'Access Suppliers', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Create Supplier', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit Supplier', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Show Supplier', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Delete Supplier', 'module_id' => $modules->id]);

        Permission::firstOrCreate(['name' => 'Access Suppliers Transaction', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Create Supplier Transaction', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit Supplier Transaction', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Delete Supplier Transaction', 'module_id' => $modules->id]);

        $branchSuperAdmin->givePermissionTo([
            'Access Admin Dashboard',
        ]);

        Permission::firstOrCreate(['name' => 'Access TrxHeads', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Create TrxHead', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit TrxHead', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Delete TrxHead', 'module_id' => $modules->id]);

        $branchSuperAdmin->givePermissionTo([
            'Access TrxHeads',
            'Create TrxHead',
            'Edit TrxHead',
            'Delete TrxHead',
        ]);


        Permission::firstOrCreate(['name' => 'Access ProductCategorys', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Create ProductCategory', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit ProductCategory', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Delete ProductCategory', 'module_id' => $modules->id]);

        $branchSuperAdmin->givePermissionTo([
            'Access ProductCategorys',
            'Create ProductCategory',
            'Edit ProductCategory',
            'Delete ProductCategory',
        ]);

        Permission::firstOrCreate(['name' => 'Access TodayRates', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Create TodayRate', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit TodayRate', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Delete TodayRate', 'module_id' => $modules->id]);

        $branchSuperAdmin->givePermissionTo([
            'Access TodayRates',
            'Create TodayRate',
            'Edit TodayRate',
            'Delete TodayRate',
        ]);

        $modules = Module::firstOrCreate(
            ['name' => 'Expenses']
        );

        Permission::firstOrCreate(['name' => 'Access Expenses', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Create Expense', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Show Expens', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Edit Expense', 'module_id' => $modules->id]);
        Permission::firstOrCreate(['name' => 'Delete Expense', 'module_id' => $modules->id]);

        $branchSuperAdmin->givePermissionTo([
            'Access Expenses',
            'Create Expense',
            'Show Expens',
            'Edit Expense',
            'Delete Expense',
        ]);
    }
}
