<?php
 
//use App\Models\User;
 
class SentrySeeder extends Seeder {
 
    public function run()
    {
        // DB::table('users')->delete();
        // DB::table('groups')->delete();
        // DB::table('users_groups')->delete();

        UserGroup::truncate();
        User::truncate();
        Group::truncate();
       
 
        Sentry::getUserProvider()->create(array(
            'email'       => 'nattapong.kongmun@gmail.com',
            'password'    => "admin",
            'first_name'  => 'Optimus',
            'last_name'   => 'Prime',
            'avatar'      => '',
            'activated'   => 1
        ));
		
        Sentry::getUserProvider()->create(array(
            'email'       => 'nor@ywsgroup.com',
            'password'    => "helloguest",
            'first_name'  => 'Nor',
            'last_name'   => 'ywsgroup',
			'avatar'      => '',
            'activated'   => 1
        ));

        Sentry::getUserProvider()->create(array(
            'email'       => 'pooh@gmail.com',
            'password'    => "pooh",
            'first_name'  => 'akapong',
            'last_name'   => 'soontornkitworakul',
			'avatar'      => '',
            'activated'   => 1
        ));

        // allow all permission for super admin
        $permissions = Config::get('permission.keys');
 
        Sentry::getGroupProvider()->create(array(
            'name'        => 'Admin',
            'permissions' => $permissions
            // 'permissions' => array(
            //     'admin'             => 1, 
            //     'article'           => 1,
            //     'article.show'      => 1,
            //     'article.edit'      => 0,
            //     'article.delete'    => 0,
            //     'page'              => 1,
            //     )
        ));
 
        // Assign user permissions
        $adminUser  = Sentry::getUserProvider()->findByLogin('nattapong.kongmun@gmail.com');
        $adminGroup = Sentry::getGroupProvider()->findByName('Admin');
        $adminUser->addGroup($adminGroup);
    }
 
}