<?php


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
}
