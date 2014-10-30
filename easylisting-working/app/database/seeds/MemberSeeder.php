<?php

class MemberSeeder extends Seeder {
 
    public function run()
    {
        DB::table('members')->delete();

        $member = Member::create(array(
            'email'         => 'info@easylisting.co.th',
            'password'      => 'easycar',
            'first_name'    => 'easycar',
            'last_name'     => 'easycar',
			'verified'		=> 1
        ));

    }
 
}