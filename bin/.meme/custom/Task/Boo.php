<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Custom\Task;

use Meme\Output;
use Meme\Task\Task;

class Boo extends Task
{
	public function __construct($link)
	{
		Output::taskHeader("HELO from BOOOOO with {$link}");
	}

	/**
	 * Выполнение действия
	 *
	 * @return mixed
	 */
	public function run()
	{
		Output::taskHeader("Boo task started");
	}
}

