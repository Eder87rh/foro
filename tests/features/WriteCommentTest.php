<?php

class WriteCommentTest extends FeatureTestCase
{
   function test_a_user_can_wirte_a_comment()
    {
        Notification::fake();

        $post = $this->createPost();
        $this->actingAs($this->defaultUser())
        	->visit($post->url)
        	->type('un comentario','comment') 
        	->press('Publicar comentario');


    	$this->seeInDatabase('comments',[
    			'comment' => 'un comentario',
    			'user_id' => $this->defaultUser()->id,
    			'post_id' => $post->id
    		]);

    	$this->seePageIs($post->url);
    }
}
