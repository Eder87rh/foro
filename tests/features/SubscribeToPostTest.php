<?php

use App\User;


class SubscribeToPostTest extends FeatureTestCase
{
  	function test_a_user_can_subscribe_to_post()
    {
    	//Having
        $post = $this->createPost();

        $user = factory(User::class)->create();

        $this->actingAs($user);

        //When

        $this->visit($post->url)
        		->press('Suscribirse al post');

		$this->seeInDatabase('subscriptions',[
				'user_id' => $user->id,
				'post_id' => $post->id
			]); 

		$this->seePageIs($post->url)
			->dontSee('Suscribirse al post');
    }

    function test_a_user_can_unsuscribe_to_post()
    {
    	//Having
        $post = $this->createPost();

        $user = factory(User::class)->create();

        $user->subscribeTo($post);

        $this->actingAs($user);

        //When
        $this->visit($post->url)
        	->dontSee('Suscribirse al post')
        	->press('Desuscribirse del post');

        $this->dontSeeInDatabase('subscriptions',[
        		'user_id' => $user->id,
        		'post_id' => $post->id
        	]);

        $this->seePageIs($post->url);


    }
}
