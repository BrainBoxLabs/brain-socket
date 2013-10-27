<?php
namespace BrainboxLabs\BrainSocket;

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BrainSocket extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'brainsocket:start';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Ratchet Websocket Server command to get you up and running with WebSockets and Laravel.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{

		$server = IoServer::factory(
			new WsServer(
				new BrainSocketEventListener(new BrainSocketResponse())
			)
			, 8080
		);

		$server->run();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			/*array('example', InputArgument::REQUIRED, 'An example argument.'),*/
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			/*array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),*/
		);
	}

}