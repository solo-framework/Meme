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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Init extends BaseCommand
{
	protected $checkProject = true;

	protected function configure()
	{
		$this->checkProject = true;
		$this
				->setName('init')
				->setDescription('Creates new Meme project')
				->addArgument(
						'env',
						InputArgument::REQUIRED,
						'Name of environment. For example: "meme init dev" will create a "dev" environment'
				)
//				->addOption(
//						'yell',
//						null,
//						InputOption::VALUE_NONE,
//						'If set, the task will yell in uppercase letters'
//				)
		;
	}

	protected function execute(InputInterface $i, OutputInterface $o)
	{
		$o->writeln("Creating new Meme project");

		$env = $i->getArgument('env');

		if (is_dir($this->configDir))
		{
			$o->writeln("<info>Project already exists</info>");
			return 1;
		}
		else
		{
			mkdir($this->configDir);
			mkdir($this->configDir . '/tasks');
			touch($this->configDir . '/tasks/.gitignore');

			$yml = $this->configDir . "/{$env}.yml";
			touch($yml);
			touch($this->configDir . "/{$env}.php");
//			if (is_file($yml))
//				$o->writeln("<error>Environment '{$env}' already exists</error>");
//			else

		}

		$o->writeln("<info>Project has been successfully created</info>");
		return 0;
	}

}

