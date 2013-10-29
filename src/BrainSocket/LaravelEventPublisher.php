<?php
namespace BrainSocket;

use Illuminate\Support\Facades\Event;

class LaravelEventPublisher implements EventPublisherInterface{

	public function fire($event,$data=array(),$stop_if_data_returned=true){
		return Event::fire($event,$data,$stop_if_data_returned);
	}

}