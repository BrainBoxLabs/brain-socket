BrainSocket.php
============

**NOTE: BrainSocket is ideal for heavier front-end development (think single page javascript apps etc). We are currently working on integrating PUSH notifications into the next release.**

WebSockets for realtime event-driven Laravel apps.

This Laravel 4 package provides an Artisan command to setup and run a WebSocket server
with [Ratchet](http://socketo.me/) inside of a Laravel app.

Lets begin by installing this package through Composer. Edit your Laravel project's `composer.json` file and add the require `brainboxlabs/brain-socket`:

```json
	"require": {
		...
		"brainboxlabs/brain-socket": "v1.0.0"
	},
```

**Note:** make sure and check [packagist.org](https://packagist.org) for updated dependencies but the list above is what has been tested at the time of this writing.

Once the package and all of its dependencies have been installed we need to add the **BrainSocketServiceProvider** to our `app/config/app.php` file.

Add this line:

```php
'providers' => array(
	...
	'BrainSocket\BrainSocketServiceProvider',
```

to the end of the providers array in the config file.

There is also an optional but recommended Facade you should add to the `aliases` array in the `app/config/app.php` file.

```php
'aliases' => array(
	...
	'BrainSocket'     => 'BrainSocket\BrainSocketFacade',
```

Next open `terminal` and `cd` into your Laravel project directory.

run `php artisan list` and confirm you see the `brainsocket:` command in the list of commands. It should look like this:

```php
Available commands:
brainsocket
	brainsocket:start
```

Once you have confirmed the list, run the following command to start the WebSocket server:

```php
php artisan brainsocket:start
```

**Note:** The websocket server runs on port 8080 by default. You can change this with the optional **--port=port_number** on the end of the artisan command.

```php
php artisan brainsocket:start --port=8081
```

At this point you should see a message in the terminal saying the websocket has been started on the selected port. Terminal will be locked down / unusable at this point, to stop the WebSocket server
hit `ctrl+c` in the terminal.

**Note:** Any changes to your laravel app / code while the ws server is running are not taken into account. You need to restart the ws server to see any of your changes.

Lets stop the ws server now by hitting `ctrl+c` in the terminal.

Next in your `app/` folder create a file called `events.php`

Lets add the following code to `events.php`:

```php
<?php
Event::listen('generic.event',function($client_data){
	return BrainSocket::message('generic.event',array('message'=>'A message from a generic event fired in Laravel!'));
});

Event::listen('app.success',function($client_data){
	return BrainSocket::success(array('There was a Laravel App Success Event!'));
});

Event::listen('app.error',function($client_data){
	return BrainSocket::error(array('There was a Laravel App Error!'));
});
```

**Note:** The `$client_data` parameter passed into the event listener is a POPO (Plain Old PHP Object) with all of the data passed from the client side.

**Note:** The `app.success` and `app.error` events are not required but are helper events for dealing with flash messaging.

Now in `app/start/global.php` add the following line at the end of the file:

```php
require app_path().'/filters.php';
require app_path().'/events.php';
```

Great! Now we have a few events to test out on the client side. Run the artisan command `php artisan brainsocket:start` to start the ws server again.

To make things easier we have created a simple js helper that allows us to interact with our new ws server a bit easier.
It's not required but it handles some minor formatting tasks in the background so you don't have to and pairs nicely with our BrainSocket Facade.

Head over to [https://github.com/BrainBoxLabs/brain-socket-js](https://github.com/BrainBoxLabs/brain-socket-js) to grab it.