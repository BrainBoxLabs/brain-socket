<?php

use BrainSocket\BrainSocketResponse;

class BrainSocketResponseTest extends PHPUnit_Framework_TestCase{

	protected function tearDown(){
		Mockery::close();
	}

	protected function mockEventPublisher(){
		$mock = Mockery::mock('BrainSocket\EventPublisherInterface');
		return $mock;
	}

	public function testResponseReturnsObjectWithAClientProperty(){
		$mock = $this->mockEventPublisher();
		$mock->shouldReceive('fire')->once();
		$BrainSocketResponse = new BrainSocketResponse($mock);

		$response = $BrainSocketResponse->make('hello.world');

		$response = json_decode($response);

		return $this->assertObjectHasAttribute('client',$response);
	}

	public function testResponseExceptsJSONStringAndReturnsServerDataWhenEventIsFired(){

		$client_object = (object)array(
			'client' => (object)array(
					'event' => 'hello.world'
				)
		);

		$mock = $this->mockEventPublisher();
		$mock->shouldReceive('fire')->once()->with($client_object->client->event,array($client_object->client))->andReturn('foo');
		$BrainSocketResponse = new BrainSocketResponse($mock);

		$response = $BrainSocketResponse->make(json_encode($client_object));

		$response = json_decode($response);

		return $this->assertObjectHasAttribute('server',$response);
	}

}