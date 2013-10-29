<?php
namespace BrainSocket;

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;

class BrainSocketServer{
	protected $server;

	public function start($port){
		$this->server = IoServer::factory(
			new HttpServer(
				new WsServer(
					new BrainSocketEventListener(
						new BrainSocketResponse(new LaravelEventPublisher())
					)
				)
			)
			, $port
		);
	}

	public function run(){
		$this->server->run();
	}

}