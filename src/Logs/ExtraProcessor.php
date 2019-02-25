<?php

namespace Foundry\Logs;

class ExtraProcessor {

	public function __invoke(array $record)
	{
		$record['extra'] = [
			'origin' => request()->headers->get('origin'),
			'user_id' => auth()->user() ? auth()->user()->id : null,
			'ip' => request()->server('REMOTE_ADDR'),
			'user_agent' => request()->server('HTTP_USER_AGENT'),
			'session' => request()->hasSession() ? request()->session()->getId(): null
		];
		return $record;
	}
}