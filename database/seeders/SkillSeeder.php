<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
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
                    'name' => 'Laravel',
                ],
                [
                    'id' => 2,
                    'name' => 'Codeigniter',
                ],
                [
                    'id' => 3,
                    'name' => 'Figma',
                ],
                [
                    'id' => 4,
                    'name' => 'API',
                ],
                [
                    'id' => 5,
                    'name' => 'PostgreSQL',
                ],
                [
                    'id' => 6,
                    'name' => 'MySQL',
                ],
                [
                    'id' => 7,
                    'name' => 'Docker',
                ],
                [
                    'id' => 8,
                    'name' => 'Linux',
                ],
                [
                    'id' => 9,
                    'name' => 'JQuery',
                ],
                [
                    'id' => 10,
                    'name' => 'ReactJS',
                ],
                [
                    'id' => 11,
                    'name' => 'VueJS',
                ],
                [
                    'id' => 12,
                    'name' => 'Java',
                ],
                [
                    'id' => 13,
                    'name' => 'Kotlin',
                ],
                [
                    'id' => 14,
                    'name' => 'Flutter',
                ],
                [
                    'id' => 15,
                    'name' => 'PHP',
                ],
                [
                    'id' => 16,
                    'name' => 'Javascript',
                ],
                [
                    'id' => 17,
                    'name' => 'Photoshop'
                ]
            ];

            foreach ($data as $key => $value) {
                $skill = Skill::find($value['id']);

                if (empty($skill)) {
                    $skill = new Skill();
                }

                $skill->name = $value['name'];
                $skill->save();
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
