<?php
class UserTableSeeder extends Seeder {
    public function run()
    {
        //DB::table('users')->delete();

        User::create(array(
            'lastname' => 'President',
            'firstname' => 'John',
            'middlename' => 'Middlename',
            'Address' => 'Miami LLC',
            'email' => 'john.president@gmail.com',
            'password' => 'f5bb0c8de146c67b44babbf4e6584cc0',
            'contact' => '09335465853',
            'type' => '2',
        ));
        User::create(array(
            'lastname' => 'Treasurer',
            'firstname' => 'John',
            'middlename' => 'Middlename',
            'Address' => 'Miami LLC',
            'email' => 'john.treasurer@gmail.com',
            'password' => 'f5bb0c8de146c67b44babbf4e6584cc0',
            'contact' => '09335465853',
            'type' => '1',
        ));
        User::create(array(
            'lastname' => 'Secretary',
            'firstname' => 'John',
            'middlename' => 'Middlename',
            'Address' => 'Miami LLC',
            'email' => 'john.secretary@gmail.com',
            'password' => 'f5bb0c8de146c67b44babbf4e6584cc0',
            'contact' => '09335465853',
            'type' => '0',
        ));
    }
}