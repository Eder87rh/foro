<?php

use App\Mail\TokenMail;
use App\{User,Token};
use Illuminate\Support\Facades\Mail;

class RegistrationTest extends FeatureTestCase
{
   	function test_a_user_can_create_an_account()
    {
        Mail::fake();

        $this->visitRoute('register')
        	->type('admin@styde.net','email')
        	->type('silence','username')
        	->type('Eder','first_name')
        	->type('Ramírez','last_name')
        	->press('Regístrate');

        $this->seeInDatabase('users',[
        		'email' => 'admin@styde.net',
        		'username' => 'silence',
        		'first_name' => 'Eder',
        		'last_name' => 'Ramírez' 
        	]);

        $user = User::first();

        $this->seeInDatabase('tokens',[
        		'user_id' => $user->id
        	]);

        $token = Token::where('user_id',$user->id)->first();

        $this->assertNotNull($token);

        Mail::assertSentTo($user,TokenMail::class,function($mail) use ($token){
        	return $mail->token->id == $token->id; 
        });

        //TODO: Finish this feature
        return;

        $this->seeRouteIs('register_confirmation')
            ->see('Gracias por registrarte')
            ->see('Enviamos a tu email un enlace para que inicies sesión');
    }
}
