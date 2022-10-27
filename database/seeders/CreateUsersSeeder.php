<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'externalUserId' => 1,
            'fullName' => 'Admin user',
            'firstName' => 'Admin',
            'lastName' => 'user',
            'email' => 'admin@email.com',
            'password' => bcrypt('123456'),
            'statusId' => User::STATUS_ACTIVE,
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $user = User::create([
            'externalUserId' => 2,
            'fullName' => 'SCIM Manager',
            'firstName' => 'SCIM',
            'lastName' => 'Manager',
            'email' => 'scim@email.com',
            'password' => bcrypt('123456'),
            'statusId' => User::STATUS_ACTIVE,
        ]);

        $role = Role::create(['name' => 'SCIM API']);

        $permissions = Permission::where('name', 'like', 'scim-%')->pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
