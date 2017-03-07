<?php

use App\Comment;
use App\User;



class SupportMarkdownTest extends FeatureTestCase
{
    function test_the_post_constent_supports_markdown()
    {
        $importantText = 'Un texto muy importante';

        $post = $this->createPost([
        		'content'=>  "La primera parte del texto . **$importantText**. La última parte del texto"
        	]);

        $this->visit($post->url)
        		->seeInElement('strong',$importantText);

    }

    function test_the_comment_supporst_markdown()
    {
    	$importantText = "Otro texto importante";


    	$comment = factory(Comment::class)->create([
    			'comment' => "La primera parte. **$importantText**. La última parte."
    		]);

    	$this->visit($comment->post->url)
    		->seeInElement('strong',$importantText);

    }

    function test_the_post_is_escaped()
    {
    	$xssAttack = "<script> alert('jojojo'); </script>";

    	$post = $this->createPost([
    			'content' => "`$xssAttack`.texto normal"
    		]);

    	$this->visit($post->url)
    		->dontSee($xssAttack)
    		->seeText("texto normal")
    		->seeText($xssAttack);

    }

    function test_xss_attack()
    {
    	$xssAttack = "<script> alert('jojojo'); </script>";

    	$post = $this->createPost([
    			'content' => "$xssAttack.texto normal"
    		]);

    	$this->visit($post->url)
    		->dontSee($xssAttack)
    		->seeText("texto normal")
    		->seeText($xssAttack);

    }

    function test_xss_attack_with_html()
    {
    	$xssAttack = "<img src= 'img.jpg'>";

    	$post = $this->createPost([
    			'content' => "$xssAttack.texto normal"
    		]);

    	$this->visit($post->url)
    		->dontSee($xssAttack);

    }
}
