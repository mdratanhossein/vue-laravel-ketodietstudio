<?php

use Illuminate\Database\Seeder;

class MembershipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memberships')
            ->insert([
                ['price'  => '46', 'currency' => 'USD', 'duration' => '3'],
                ['price'  => '66', 'currency' => 'USD', 'duration' => '12'],
                ['price'  => '33', 'currency' => 'USD', 'duration' => '6'],
            ]);
    }
}
