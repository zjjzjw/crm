<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('CompanySeeder');
        $this->call('UserSeeder');
        $this->call('DepartSeeder');
        $this->call('PermissionSeeder');
        $this->call('RoleSeeder');
        $this->call('UserSeeder');
        $this->call('AreaSeeder');
        $this->call('ProvinceSeeder');
        $this->call('CitySeeder');
        $this->call('CountySeeder');

        Model::reguard();
    }
}
