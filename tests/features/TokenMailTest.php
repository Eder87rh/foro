<?php

use App\Mail\TokenMail;
use App\{User, Token};
use Illuminate\Mail\Mailable;
use Symfony\Component\DomCrawler\Crawler;

class TokenMailTest extends FeatureTestCase
{
	/**
	 * [it_sends_a_link_with_the_token description]
	 * @test
	 */
    function it_sends_a_link_with_the_token()
    {
    	$user = new User([
    			'first_name' => 'Eder',
    			'last_name' => 'Ramírez',
    			'email' => 'eder.ramirez87@gmail.com'
    		]);

       	$token = new Token([
       			'token' => 'this-is-a-token',
       			'user' => $user
		]);

		
       	$this->open(new TokenMail($token))
       	     ->seeLink($token->url,$token->url);
    }

    protected function open(Mailable $mailable)
    {
        $transport = Mail::getSwiftMailer()->getTransport();

        $transport->flush();

    	Mail::send($mailable);


        $message = $transport->messages()->first();

        $this->crawler = new Crawler($message->getBody());

        return $this;
    }
}
