<?php
/**
 * Консольное приложение
 *
 * PHP version 5
 *
 * @package Meme
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme;

use Meme\Command\ListEnv;
use Symfony\Component\Console\Application;

class Meme extends Application
{
	public function __construct()
	{
		set_error_handler(array($this, "throwErrorException"));

		parent::__construct("\nWelcome to Meme - build and deployment tool", "");
		$this->setCatchExceptions(true);
		$this->setAutoExit(true);


		// todo: load commands from dir
		$this->addCommands(array(
			new Command\Init(),
			new Command\Run(),
			new Command\Info()
		));
	}

	public function throwErrorException($errno, $errstr, $errfile, $errline)
	{
		if (!($errno & error_reporting()))
			return false;

		throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
	}
}

