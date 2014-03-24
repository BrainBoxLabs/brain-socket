<?php
namespace BrainSocket;

use Illuminate\Support\Facades\App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class BrainSocketEventListener implements MessageComponentInterface {
	protected $clients;
	protected $response;

	public function __construct(BrainSocketResponseInterface $response) {
		$this->clients = new \SplObjectStorage;
		$this->response = $response;
	}

	public function onOpen(ConnectionInterface $conn) {
		echo "Connection Established! \n";
		$this->clients->attach($conn);
	}

	public function onMessage(ConnectionInterface $from, $msg) {
		$numRecv = count($this->clients) - 1;
		echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
			, $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $message = $this->response->make($msg);
		foreach ($this->clients as $client) {
			$client->send($message);
		}
	}

	public function onClose(ConnectionInterface $conn) {
		$this->clients->detach($conn);
		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		echo "An error has occurred: {$e->getMessage()}\n";
		$conn->close();
	}
}