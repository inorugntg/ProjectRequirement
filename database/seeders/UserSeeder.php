<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $password = bcrypt(config('myconfig.default_password'));

            $data = [
                [
                    'id' => 1,
                    'name' => 'Super Admin',
                    'username' => 'super_admin',
                    'password' => $password,
                ],
            ];

            foreach ($data as $key => $value) {
                $user = User::find($value['id']);

                if (empty($user)) {
                    $user = new User();
                }

                $user->name = $value['name'];
                $user->username = $value['username'];
                $user->password = $value['password'];
                $user->save();
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
