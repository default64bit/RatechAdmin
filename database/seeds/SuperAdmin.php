<?php

use Illuminate\Database\Seeder;
use App\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'name'=>'kasra keshvardoost',
            'username'=>'kasra',
            'email'=>'kasrakeshvardoost@gmail.com',
            'password'=>bcrypt('12345678'),
        ]);

        $role = Role::create([
            'name'=>'SuperAdmin',
            'label'=>'SuperAdmin',
            'guard_name'=>'admin',
        ]);

        $default_permissions = [
            ['admin.browse','جستجو ادمین'],
            ['admin.read','مشاهده ادمین'],
            ['admin.edit','ویرایش ادمین'],
            ['admin.add','افزودن ادمین'],
            ['admin.delete','حذف ادمین'],

            ['role.browse','جستجو نقش'],
            ['role.read','مشاهده نقش'],
            ['role.edit','ویرایش نقش'],
            ['role.add','افزودن نقش'],
            ['role.delete','حذف نقش'],

            ['permission.browse','جستجو دسترسی'],
            ['permission.read','مشاهده دسترسی'],
            ['permission.edit','ویرایش دسترسی'],
            ['permission.add','افزودن دسترسی'],
            ['permission.delete','حذف دسترسی'],
        ];
        foreach($default_permissions as $default_permission){
            $permission = Permission::create([
                'name'=>$default_permission[0],
                'label'=>$default_permission[1],
                'guard_name'=>'admin',
            ]);
            $role->givePermissionTo($permission);
        }

        $admin = Admin::where('email','kasrakeshvardoost@gmail.com')->first();
        $admin->assignRole('SuperAdmin');
    }
}
