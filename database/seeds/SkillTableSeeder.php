<?php

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            'Photoshop',
            'Logo Design & Branding',
            'Photography',
            'Web Developer',
            'Android Developer',
            'Ios Developer',
            'Nodejs Developer'
        ];
        foreach($data as $value){
            Skill::create([
                'name'=>$value,
                'description'=>''
            ]);
        }
       
    }
}
