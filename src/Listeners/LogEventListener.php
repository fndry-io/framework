<?php

namespace Foundry\Listeners;

use Foundry\Events\LogEvent;
use Foundry\Models\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogEventListener implements ShouldQueue {

	public $queue = 'logs';

	protected $log;

	public function __construct(Log $log) {
		$this->log = $log;
	}

	/**
	 * @param $event
	 */
	public function onLog($event)
	{
		Log::saveRecord($event->record);
	}

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param \Illuminate\Events\Dispatcher $events
	 */
	public function subscribe($events)
	{
		$events->listen(
			LogEvent::class,
			'Foundry\Listeners\LogEventListener@onLog'
		);
	}
}