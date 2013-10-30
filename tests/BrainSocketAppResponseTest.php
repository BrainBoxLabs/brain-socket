<?php

use BrainSocket\BrainSocketAppResponse;

class BrainSocketAppResponseTest extends PHPUnit_Framework_TestCase{

	protected function tearDown(){
		Mockery::close();
	}

	public function testMessageReturnsAnObject(){

		$AppResponse = new BrainSocketAppResponse();

		$response = $AppResponse->message('some.event');

		$this->assertObjectHasAttribute('data',$response);
		return $this->assertObjectHasAttribute('event',$response);
	}

}