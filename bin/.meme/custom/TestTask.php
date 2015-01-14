<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Custom;

use Meme\Output;

class TestTask
{
	public function __construct()
	{
		Output::taskHeader("HELLOO");
		//print_r("HELLO!!!");
	}
}

