<?php
namespace BrainSocket;

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
	protected $description = 'Starts BrainSocket and the Ratchet WebSocket server to start running event-driven apps with Laravel.';

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
			, $this->option('port')
		);

		$this->info('WebSocket server started on port:'.$this->option('port'));
		$server->run();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('port', null, InputOption::VALUE_OPTIONAL, 'The port you want the websocket server to run on (default: 8080)','8080'),
		);
	}

}