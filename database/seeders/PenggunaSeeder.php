<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggunaSeeder extends Seeder
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
            $data = [
                [
                    'nama' => 'Ahmes',
                    'birth_year' => '2006',
                    'email' => 'ikiahmes@gmail.com',
                    'phone' => '089492837231',
                    'job' => 'FrontEnd Engineer',
                    'skill' => 'ReactJS, JQuery'
                ],
                [
                    'nama' => 'Bara',
                    'birth_year' => '2005',
                    'email' => 'ikibara@gmail.com',
                    'phone' => '089492837232',
                    'job' => 'BackEnd Engineer',
                    'skill' => 'Laravel, API'
                ],
                [
                    'nama' => 'Caesar',
                    'birth_year' => '2007',
                    'email' => 'ikicaesar@gmail.com',
                    'phone' => '089492837233',
                    'job' => 'DevOps Engineer',
                    'skill' => 'Linux, Docker'
                ],
                [
                    'nama' => 'Dioo',
                    'birth_year' => '2004',
                    'email' => 'ikidio@gmail.com',
                    'phone' => '089492837234',
                    'job' => 'UI/UX Engineer',
                    'skill' => 'Figma, Photoshop'
                ],
                [
                    'nama' => 'Erlangga',
                    'birth_year' => '2006',
                    'email' => 'ikierlangga@gmail.com',
                    'phone' => '089492837235',
                    'job' => 'Network Engineer',
                    'skill' => 'Firewall, Security skills'
                ],
                [
                    'nama' => 'Fajar',
                    'birth_year' => '2006',
                    'email' => 'ikifajar@gmail.com',
                    'phone' => '089492837236',
                    'job' => 'Mobile Engineer',
                    'skill' => 'Flutter, Kotlin'
                ],
                [
                    'nama' => 'Georgys',
                    'birth_year' => '2006',
                    'email' => 'ikigeorgys@gmail.com',
                    'phone' => '089492837236',
                    'job' => 'Software Quality Assurance',
                    'skill' => 'Test Software, Website'
                ],
            ];

            foreach ($data as $key => $value) {
                $register = Register::find($value);

                if (empty($register)) {
                    $register = new Register();
                }

                    $register->nama = $value['nama'];
                    $register->birth_year = $birth_year['nama'];
                    $register->email = $value['email'];
                    $register->phone = $value['phone'];
                    $register->job = $value['job'];
                    $register->skill = $value['skill'];
                    $job->save();
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
