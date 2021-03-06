<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends TestCase
{
	use DatabaseTransactions;
  
    function test_a_slug_is_generated_and_saved_to_database()
    {
        
       $post = $this->createPost([
        		'title' => 'Como instalar laravel'
        	]);
 

     	$this->assertSame(
     		'como-instalar-laravel',
     		$post->fresh()->slug
     	);

        //   $this->seeInDataBase('post',[
     	// 	'slug' => 'como-instalar-laravel'
     	// ]);

     	// $this->assertSame('como-instalar-laravel',$post->slug);

     	
    }
}
