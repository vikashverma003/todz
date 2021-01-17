<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Admin;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'client_management_access',
        'talent_management_access',
        'coupon_management_access',
        'projects_management_access',
        'categories_management_access',
        'services_management_access',
        'skills_management_access',
        'rating_management_access',
        'escalations_management_access',
        'faq_management_access',
        'sitecontent_management_access',
        'financial_reports_access',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        foreach ($this->permissions as $row) {
            Permission::firstOrCreate([
                'title' => $row
            ]);
        }

        //Admin::where('email', 'admin@code-brew.com')->update(['is_super'=>1]);
    }
}
