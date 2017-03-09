<?php

use App\Post;

class CreatePostsTest extends FeatureTestCase
{
	public function test_a_user_create_a_post()
	{
		//Having
		$title='Esta es una pregunta';
		$content = 'Este es el contenido';

		$this->actingAs($user = $this->defaultUser());

		//When
		$this->visit(route('posts.create'))
			->type($title, 'title')
			->type($content,'content')
			->press('Publicar');

  		//Then 
		$this->seeInDataBase('posts',[
				'title' => $title,
				'content' => $content,
				'pending' => true,
				'user_id' => $user->id,
			]);

		$post = Post::first();

		//Test the author of the post is subscribed automatically to his post
		$this->seeInDatabase('subscriptions',[
				'user_id' => $user->id,
				'post_id' => $post->id
			]); 

		//Test user is redirected to post details after creating it
		$this->seePageIs($post->url);
	}

	function test_creating_a_post_requires_authentication()
	{
		
		//When
		$this->visit(route('posts.create'))
			 ->seePageIs(route('login'));

	}

	function test_create_post_form_validation()
	{
		$this->actingAs($this->defaultUser())
			->visit(route('posts.create'))
			->press('Publicar')
			->seePageIs(route('posts.create'))
			->seeErrors([
					'title' => 'El campo título es obligatorio',
					'content' => 'El campo contenido es obligatorio'
				]);
			// ->seeInElement('#field_title .help-block','El campo título es obligatorio')
			// ->seeInElement('#field_content .help-block','El campo contenido es obligatorio');
	}

}