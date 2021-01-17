<?php

use Illuminate\Database\Seeder;
use App\Models\JobCategory;
class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories=[
            'Content Writer Expert',
            'Graphic Designer Expert',
            'Web Designer UI & UX Expert',
            'Web Developer Expert',
            'Project Management Consultant',
            'Legal Consultant',
            'Data Entry Expert',
            'HR Consultant',
            'Business Development Strategist',
            'Translator Expert',
            'Operation Strategist',
            'Digital Media Plan Strategist',
            'App. Developer Expert',
            'Research Consultant',
            'Virtual Assistant Expert',
            'Voice Over Expert',
        ];
        foreach($categories as $value){
            JobCategory::create([
                'name'=>$value,
              //  'description'=>''
            ]);
        }
    }
}
