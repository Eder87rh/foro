<?php

use App\Comment;
use App\User;




class AcceptAnswerTest extends FeatureTestCase
{
    function test_posts_author_can_accept_an_answer()
    {
        $comment = factory(Comment::class)->create([
			'comment' => 'Esta va a ser la respuesta del post.'
		]);

        $this->actingAs($comment->post->user);

        $this->visit($comment->post->url)
        	->press('Aceptar respuesta');

		 $this->seeInDatabase('posts',[
        		'id' => $comment->post_id,
        		'pending' => false,
        		'answer_id' =>  $comment->id
        	]);	

        $this->seePageIs($comment->post->url)
        	 //->seeInElement('#comentario',$comment->comment);
			 ->seeInElement('.answer',$comment->comment);
       
    }

    function test_non_author_dont_see_accept_an_answer_button()
    {
        $comment = factory(Comment::class)->create([
			'comment' => 'Esta va a ser la respuesta del post.'
		]);

        $this->actingAs(factory(User::class)->create());

        $this->visit($comment->post->url)
        	->dontSee('Aceptar respuesta');

       
    }

    function test_non_author_cannot_accept_an_answer()
    {
        $comment = factory(Comment::class)->create([
			'comment' => 'Esta va a ser la respuesta del post.'
		]);

        $this->actingAs(factory(User::class)->create());

        $this->post(route('comments.accept',$comment));

		 $this->seeInDatabase('posts',[
        		'id' => $comment->post_id,
        		'pending' => true
        	]);	
       
    }

    function test_accept_button_is_hidden_when_the_comment_is_already_the_post_answer()
    {
        $comment = factory(Comment::class)->create([
			'comment' => 'Esta va a ser la respuesta del post.'
		]);

        $this->actingAs($comment->post->user);
		
		$comment->markAsAnswer();

        $this->visit($comment->post->url)
        	->dontSee('Aceptar respuesta');

       
    }
}
