<?php

namespace Database\Seeders;

 use Illuminate\Database\Seeder;
 use Illuminate\Support\Facades\DB;
 use App\Models\Pengguna;

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
                     'id' => 10,
                     'nama' => 'Ahmes',
                     'date' => '05-02-2006',
                     'email' => 'ikiahmes@gmail.com',
                     'phone' => '087691214884',
                     'job' => 'UI/UX Engineer',
                     'skill' => 'Figma'
                 ],
                 [
                     'id' => 10,
                     'nama' => 'Bayu',
                     'date' => '2006',
                     'email' => 'bayuurd@gmail.com',
                     'phone' => '086129777278',
                     'job' => 'BackEnd Engineer',
                     'skill' => 'Codeigniter'
                 ],
                 [
                     'id' => 3,
                     'nama' => 'Caesar',
                     'date' => '2005',
                     'email' => 'caesangar@gmail.com',
                     'phone' => '085213791989',
                     'job' => 'FrontEnd Engineer',
                     'skill' => 'Bootstrap',
                 ],
                 [
                     'id' => 4,
                     'nama' => 'Dito',
                     'date' => '2005',
                     'email' => 'ditohn@gmail.com',
                     'phone' => '081273981794',
                     'job' => 'Mobile Engineer',
                     'skill' => 'Flutter'
                 ],
                 [
                     'id' => 5,
                     'nama' => 'Erlangga',
                     'date' => '2006',
                     'email' => 'ErlanggaArya@gmail.com',
                     'phone' => '082823988373',
                     'job' => 'Network Engineer',
                     'skill' => 'Docker'
                 ],
             ];

             foreach ($data as $key => $value) {
                 $user = Pengguna::find($value['id']);

                 if (empty($user)) {
                     $user = new Pengguna();
                 }

                 $user->nama = $value['nama'];
                 $user->date = $value['date'];
                 $user->email = $value['email'];
                 $user->phone = $value['phone'];
                 $user->job = $value['job'];
                 $user->skill = $value['skill'];
                 $user->save();
             }

             DB::commit();
         } catch (\Exception $ex) {
             DB::rollBack();
             echo $ex->getMessage();
         }
     }
 }
 ?>