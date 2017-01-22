<?php


class ExampleTest extends FeatureTestCase
{
    
    function test_basic_example()
    {

        $user= factory(\App\User::class)->create([
                'name'=> 'Eder Ramirez',
                'email'=>'admin@styde.net'
            ]);

        $this->actingAs($user,'api')
            ->visit('/api/user')
             ->see('Eder Ramirez')
             ->see('admin@styde.net');
    }
}
