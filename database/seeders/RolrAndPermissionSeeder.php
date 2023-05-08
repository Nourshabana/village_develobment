<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolrAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayOfPermissionNames=[
            'school.create','school.update','school.delete','school.show',
            'teacher.create','teacher.update','teacher.delete','teacher.show',
            'section.create','section.update','section.delete','section.show',
            'worker.create','worker.update','worker.delete','worker.show',
            'rate.create','rate.update','rate.delete','rate.show',
            'admin.create','admin.update','admin.delete','admin.show',
            'shop.create','shop.update','shop.delete','shop.show',
            'hospital.create','hospital.update','hospital.delete','hospital.show',
            'doctor.create','decorator.update','decorator.delete','decorator.show',
            'user.create','user.update','user.delete','user.show',
            'cilinic.create','cilinic.update','cilinic.delete','cilinic.show',
            'role.create','role.update','role.delete','role.show',
            'businisshour.create','businisshour.update','businisshour.delete','businisshour.show',
            'appointment.create','appointment.update','appointment.delete','appointment.show',

        ];
        $permission=collect($arrayOfPermissionNames)->map(function($permission){
            return ['name'=>$permission,'guard_name'=>'web'];
        });


        Permission::insert($permission->toArray());
        $role=Role::create(['name'=>'admin'])->givePermissionTo($arrayOfPermissionNames);
    }
}
