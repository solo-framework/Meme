<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme;

use Symfony\Component\Console\Application;
use Symfony\Component\Yaml\Yaml;

class Meme extends Application
{
	public function __construct()
	{
		set_error_handler(array($this, "throwErrorException"));

		parent::__construct("\nWelcome to Meme deployment tool", "0.1");
		$this->setCatchExceptions(true);
		$this->setAutoExit(true);


		// todo: load commands from dir
		$this->addCommands(array(
			new Command\Init(),
			new Command\Run(),
		));
	}

	public function throwErrorException($errno, $errstr, $errfile, $errline)
	{
		if (!($errno & error_reporting()))
			return false;

		throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
	}

//	public function run($argv)
//	{
//		$this->println("------------------------ Meme deployment tool------------------------");
//
//		$file = @$argv[1];
//
//		if (!$file)
//			$this->printError("Environment is not defined");
//
//		if (!is_file($file))
//			$this->printError("Environment {$file} doesn't exist");
//
//		$envName = pathinfo($file, PATHINFO_FILENAME);
//		$this->println("Start with '{$envName}' environment");
//
//		$envConfig = "{$envName}.yml";
//		if (!is_file($envConfig))
//			$this->printError("Environment config '{$envConfig}' doesn't exist");
//
//
//		$yaml = Yaml::parse($envConfig);
//
//		var_dump($yaml);
//		//var_dump(Yaml::dump($yaml));
//		return 0;
//	}
//
//
//	public function printError($message)
//	{
//		echo "{$message}\n\n";
//		exit(1);
//	}
//
//	public function println($text)
//	{
//		echo "{$text}\n";
//	}
}

