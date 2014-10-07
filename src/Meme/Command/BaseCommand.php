<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
	public $configDir = null;

	protected $checkProject = false;

	protected function initialize(InputInterface $input, OutputInterface $output)
	{
		$this->configDir = getcwd() . '/.meme';

		if (!$this->checkProject)
		{
			if (!is_dir($this->configDir))
			{
				$output->writeln("<error>Project doesn't exist. Please, run init command as './meme init env_name'</error>");
				exit(1);
			}
		}
	}
}

