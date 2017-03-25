<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\BrowserKitTesting\TestCase;
use Tests\CreatesApplication;
use Tests\TestsHelper;

class FeatureTestCase extends TestCase
{
	use CreatesApplication, TestsHelper,DatabaseTransactions;

	function seeErrors(array $fields)
	{

		foreach ($fields as $name => $errors) {
			foreach ((array) $errors  as $message) {
				$this->seeInElement(
					"#field_{$name} .help-block", $message
					);
			}
		}

		
	}

}