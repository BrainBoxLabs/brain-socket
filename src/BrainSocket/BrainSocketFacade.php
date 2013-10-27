<?php
namespace BrainSocket;

use Illuminate\Support\Facades\Facade;

class BrainSocketFacade extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'brain_socket'; }

}