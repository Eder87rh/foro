<?php

use App\Post;
use Carbon\Carbon;


class PostsListTest extends FeatureTestCase
{

    public function test_a_user_can_see_the_post_list_and_go_to_details()
    {
        $post = $this->createPost([
        	'title' => 'Debo usar laravel 5.3 o laravel 5.1 LTS?'
        	]);

        $this->visit('/')
        	->seeInElement('h1','Posts')
        	->see($post->title)
        	->click($post->title)
        	->seePageIs($post->url);

    }

    public function test_the_post_are_paginated()
    {
    	//Having
    	$first = factory(Post::class)->create([
    			'title' => 'Post mas antiguo',
    			'created_at' => Carbon::now()->subDays(2)
    		]);

    	factory(Post::class)->times(15)->create([
    			'created_at' => Carbon::now()->subDays(1)
    		]);

    	$last = factory(Post::class)->create([
    			'title' => 'Post mas reciente',
    			'created_at' => Carbon::now()
    		]);
		//When
		
		$this->visit('/')
			->see($last->title)
			->dontSee($first->title)
			->click(2)
			->see($first->title)
			->dontSee($last->title); 
		

    }
}
