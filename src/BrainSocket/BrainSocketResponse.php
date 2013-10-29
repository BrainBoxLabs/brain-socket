<?php
namespace BrainSocket;

use Illuminate\Support\Facades\Event;

class BrainSocketResponse implements BrainSocketResponseInterface{

	protected $eventPublisher;

	public function __construct(EventPublisherInterface $eventPublisher){
		$this->eventPublisher = $eventPublisher;
	}

	/**
	 * Takes the client message and tries to broadcast it
	 * through laravel (in case our app is listening for it).
	 * Returns a json string to be sent to all clients connected via WebSockets.
	 * @param $msg
	 * @return string
	 */
	public function make($msg){

		$json = json_decode($msg);

		if(!$json){
			$json = (object)array();
			$json->client = (object)array();
		}else{
			$json = (object)$json;
		}

		$event = $this->fireEvent($json,$msg);

		$return_json = json_encode($event);
		if($return_json === false){
			$return_json = $msg;
		}

		return $return_json;
	}

	/**
	 * Fires a laravel event and checks for a response,
	 * in which case the returned Laravel Event response is sent to all connected clients.
	 * @param $obj
	 * @return mixed
	 */
	protected function fireEvent($obj,$msg){
		$e = null;

		if(!isset($obj->client->event)){
			$obj->client->event = $msg;
		}

		$e = $this->eventPublisher->fire($obj->client->event,array($obj->client));

		if(!is_null($e)){
			$obj->server = $e;
		}

		return $obj;
	}

}