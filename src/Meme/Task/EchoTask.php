<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Task;

class EchoTask extends Task
{
	public $message = null;

	public function __construct($message)
	{
		$this->message = $message;
	}

	public function run()
	{
		echo "{$this->message}\n";
	}
}

