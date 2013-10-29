<?php
namespace BrainSocket;

interface EventPublisherInterface{

	public function fire($event,$data=array(),$stop_if_data_returned=true);

}