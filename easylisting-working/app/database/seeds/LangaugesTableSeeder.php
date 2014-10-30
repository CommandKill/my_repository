<?php

class LangaugesTableSeeder extends Seeder {

    public function run()
    {
        //DB::table('languages')->delete();

        Language::truncate();

        $languages = [
        	[
                'code'          => 'en_US',
				'short_code'    => 'en', 
                'title'         => 'English', 
                'status'        => 1, 
                'created_at'    => new DateTime, 
                'updated_at'    => new DateTime
            ],[
                'code'          => 'th_TH',
				'short_code'    => 'th',  
                'title'         => 'Thai', 
                'status'        => 1, 
                'created_at'    => new DateTime, 
                'updated_at'    => new DateTime
            ]
        ];
        	
        DB::table('languages')->insert($languages);
    }

}