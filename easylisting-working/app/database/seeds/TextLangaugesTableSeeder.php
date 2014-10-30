<?php

class TextLangaugesTableSeeder extends Seeder {

    public function run()
    {
        //DB::table('languages')->delete();

        TextLanguage::truncate();
        TextLanguage::create(array(
            'key'           => 'site_homepage',
            'value'         => 'เว็บไซต์',
            'language_id'   => 2,
            'autoload'      => 1,
            'module'        => 'global'
        ));
        TextLanguage::create(array(
            'key'           => 'site_homepage',
            'value'         => 'Website',
            'language_id'   => 1,
            'autoload'      => 1,
            'module'        => 'global'
        ));
    }

}