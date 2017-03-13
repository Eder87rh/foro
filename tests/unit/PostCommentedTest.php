<?php

use App\Comment;
use App\Notifications\PostCommented;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Notifications\Messages\MailMessage;


class PostCommentedTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * @test
     */
    function it_build_a_email_message()
    {
    	$post = factory(Post::class)->create([
    			'title' => 'Titulo del post'
    		]);

    	$author = factory(User::class)->create([
    			'name' => 'Eder Ramírez'
    		]);

    	$comment = factory(Comment::class)->create([
    			'post_id' => $post->id,
    			'user_id' => $author->id
    		]);

    	$notification = new PostCommented($comment);

    	$subscriber = factory(User::class)->create();

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
