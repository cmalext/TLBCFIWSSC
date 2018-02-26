<?php
class ClientTableSeeder extends Seeder {

    public function run()
    {
        //DB::table('users')->delete();
        Client::create(array(
            'meter_id' => 'meter-1',
            'lastname' => 'Client',
            'firstname' => 'John',
            'middlename' => 'Middlename',
            'Address' => 'Miami LLC',
            'email' => 'john.client@gmail.com',
            'password' => 'f5bb0c8de146c67b44babbf4e6584cc0',
            'contact' => '09335465853',
            'type' => '0',
            'status' => '0',
        ));
    }

}