<?php



class ShowPostTest extends FeatureTestCase
{

    public function test_a_user_can_see_a_post_details()
    {
    	//Having
    	$user = $this->defaultUser([
    			'name' =>'Eder Ramírez',

    		]);

        $post = $this->createPost([
        		'title' => 'Este es el titulo del post',
        		'content' => 'Este es el contenido del post',
        		'user_id' => $user->id
        	]);

        //dd(\App\User::all()->toArray());


		//When
        $this->visit($post->url)//posts/12345
        	->seeInElement('h1',$post->title)
        	->see($post->content)
        	->see('Eder Ramírez');
    }


    function test_old_url_redirect_to_new_url()
    {

    	//Having

	    $post = $this->createPost([
	        'title' => 'Old title',
	    ]); 

	    $url = $post->url;

	    $post->update([ 'title' => 'New title' ]);

	    $this->visit($url)
	    	->seePageIs($post->url);

    }


}
