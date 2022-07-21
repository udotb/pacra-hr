<?php

use Illuminate\Database\Seeder;

class ipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<255; $i++){
            DB::table('pacra_ips')->insert([
                'ip_address' => '39.44.56.'.$i,
            ]);
        }
    }
}
