<?php

use App\Mail\TokenMail;
use App\Token;
use Illuminate\Support\Facades\Mail;

class RequestTokenTest extends FeatureTestCase
{
    
    public function test_a_guest_user_can_request_a_token()
    {
    	//Having
        Mail::fake();

        $user = $this->defaultUser(['email' => 'admin@styde.net']);

        //When
        $this->visitRoute('token')
        	->type('admin@styde.net','email')
        	->press('Solicitar token');

        //Then: a new token is created in DB
    	$token = Token::where('user_id',$user->id)->first();

    	$this->assertNotNull($token,'A token was not created');

    	//And send to user
    	
    	Mail::assertSentTo($user,TokenMail::class, function ($mail) use ($token){
    		return $mail->token->id === $token->id;
    	});

    	$this->dontSeeIsAuthenticated();

    	$this->see('Enviamos a tu email un enlace para que inicies sesión');
    

    }

    public function test_a_guest_user_cannot_request_a_token_without_email()
    {
    	//Having
        Mail::fake();

        //When
        $this->visitRoute('token')
        	->press('Solicitar token');

        //Then: a new token is NOT created in DB
    	$token = Token::first();

    	$this->assertNull($token,'A token was created');

    	//And send to user
    	
    	Mail::assertNotSent(TokenMail::class);

    	$this->dontSeeIsAuthenticated();

    	$this->seeErrors([
    			'email' => 'El campo correo electrónico es obligatorio'
    		]);
    

    }

    public function test_a_guest_user_cannot_request_a_token_with_invalid_email()
    {

        //When
        $this->visitRoute('token')
        	->type('Silence','email')
        	->press('Solicitar token');


    	$this->dontSeeIsAuthenticated();

    	$this->seeErrors([
    			'email' => 'Este correo electrónico no es un correo válido'
    		]);
    

    }

    public function test_a_guest_user_cannot_request_a_token_with_a_non_existent_email()
    {
    
        $this->defaultUser(['email' => 'admin@styde.net']);

        //When
        $this->visitRoute('token')
        	->type('silence@styde.net','email')
        	->press('Solicitar token');


    	$this->dontSeeIsAuthenticated();

    	$this->seeErrors([
    			'email' => 'Este correo electrónico es inválido'
    		]);
    

    }
}
