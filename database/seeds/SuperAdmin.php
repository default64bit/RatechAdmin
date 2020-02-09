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
            'name'=>'kasra',
            'family'=>'keshvardoost',
            'username'=>'kasra',
            'email'=>'kasrakeshvardoost@gmail.com',
            'phone'=>'09123456789',
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
            ['admin.disable','فعال/غیرفعال سازی ادمین'],

            ['role.browse','جستجو نقش'],
            ['role.read','مشاهده نقش'],
            ['role.edit','ویرایش نقش'],
            ['role.add','افزودن نقش'],
            ['role.delete','حذف نقش'],

            ['panel_settings.browse','جستجو تنظیمات پنل'],
            ['panel_settings.read','مشاهده تنظیمات پنل'],
            ['panel_settings.edit','ویرایش تنظیمات پنل'],
            ['panel_settings.add','افزودن تنظیمات پنل'],
            ['panel_settings.delete','حذف تنظیمات پنل'],
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
