<?php

namespace Foundry\Logs;

use Foundry\Events\LogEvent;
use Foundry\Models\Log;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class DatabaseHandler extends AbstractProcessingHandler
{

	public function __construct( int $level = Logger::DEBUG, bool $bubble = true ) {
		parent::__construct( $level, $bubble );
		//Add the extra processor
		$this->pushProcessor(new ExtraProcessor());
	}

	/**
	 * {@inheritDoc}
	 */
	protected function write(array $record)
	{
		Log::saveRecord($record);
		// Queue implementation
		//event(new LogEvent($record));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function getDefaultFormatter()
	{
		return new DatabaseFormatter();
	}

}