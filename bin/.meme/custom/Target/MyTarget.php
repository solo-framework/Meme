<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Custom\Target;

use Meme\Config;
use Meme\Custom\Task\Boo;
use Meme\ITargetDefinition;
use Meme\Output;
use Meme\Target;
use Meme\TargetDefinition;
use Meme\Task\Command;
use Meme\Task\SSH\SshCommand;

class MyTarget extends TargetDefinition
{
	public function __construct($dir)
	{
		$this->setFunction(function () use ($dir)
		{
			//new SshCommand($ssh, "cd / && ls -l | grep tmp", true);
			new Command("cd {$dir} && ls");
//			Output::comment(Config::get("name"));
		});
	}
}

