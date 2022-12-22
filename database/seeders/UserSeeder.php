<?php

namespace Database\Seeders;

use App\Helpers\FakerHelper;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f = new FakerHelper();
        $height = rand(600, 900);
        $width = intval($height * 2 / 3);

        $admin = Admin::where('email', 'admin@tarsyah.com')->first();
        if (!$admin) {
            DB::table('admins')->insert([
                'name' => 'Admin',
                'email' => 'admin@tarsyah.com',
                'username' => 'admin.tarsyah',
                'status' => 1,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar' => $f->imageUrl($width, $height, 'NOT USED', false),
                'cover_image' => $f->imageUrl($width, $height, 'NOT USED', false),
                'phone_number' => '+971508706807',
                'whatsapp' => '+971508706807',
                'website_url' => 'https://contact.tarsyah.com',
                'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Pellentesque in ipsum id orci porta dapibus. Curabitur aliquet quam id dui posuere blandit. Donec rutrum congue leo eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Sed porttitor lectus nibh. Curabitur aliquet quam id dui posuere blandit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.',
            ]);
        }

        $admin = Admin::first();

        $Admin = Role::findOrCreate('Admin');
        $admin->syncRoles($Admin->id);


        foreach ( config('permission.permissions') as $permission) {
            Permission::findOrCreate($permission);
            $Admin->givePermissionTo($permission);
        }

    }
}
