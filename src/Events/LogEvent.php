<?php

namespace Foundry\Core\Events;

use Illuminate\Queue\SerializesModels;

class LogEvent {

	use SerializesModels;

	/**
	 * @var
	 */
	public $record;

	/**
	 * @param array $record
	 */
	public function __construct(array $record)
	{
		$this->record = $record;
	}
}