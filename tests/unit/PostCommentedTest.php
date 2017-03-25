<?php

use App\Comment;
use App\Notifications\PostCommented;
use App\Post;
use App\User;
use Illuminate\Notifications\Messages\MailMessage;


class PostCommentedTest extends TestCase
{
	
    /**
     * @test
     */
    function it_build_a_email_message()
    {
    	$post = new Post([
    			'title' => 'Titulo del post'
    		]);

    	$author = new User([
    			'first_name' => 'Eder',
                'last_name' => 'Ramírez'
    		]);

    	$comment = new Comment();
    	$comment->post = $post;
    	$comment->user = $author;

    	$notification = new PostCommented($comment);

    	$subscriber = new User();

    	$message = $notification->toMail($subscriber);

        $this->assertInstanceOf(MailMessage::class,$message);

        $this->assertSame(
        		'Nuevo comentario en: Titulo del post',
        		$message->subject
        	);

        $this->assertSame(
        		'Eder Ramírez escribió un comentario en: Titulo del post',
        		$message->introLines[0]
        	);

        $this->assertSame(
        		$comment->post->url,
        		$message->actionUrl
        	);
    }
}
