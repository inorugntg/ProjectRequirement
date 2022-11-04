<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
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
                    'id' => 1,
                    'name' => 'Back End Engineer',
                ],
                [
                    'id' => 2,
                    'name' => 'Front End Engineer',
                ],
                [
                    'id' => 3,
                    'name' => 'DevOps Engineer',
                ],
                [
                    'id' => 4,
                    'name' => 'UI/UX Engineer',
                ],
                [
                    'id' => 5,
                    'name' => 'Network Engineer',
                ],
                [
                    'id' => 6,
                    'name' => 'Mobile Engineer',
                ],
                [
                    'id' => 7,
                    'name' => 'Software Quality Assurance',
                ],
            ];

            foreach ($data as $key => $value) {
                $job = Job::find($value['id']);

                if (empty($job)) {
                    $job = new Job();
                }

                $job->name = $value['name'];
                $job->save();
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
