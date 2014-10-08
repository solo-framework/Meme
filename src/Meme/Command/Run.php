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

use Meme\Project;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Run extends BaseCommand
{
	protected function configure()
	{
		$this
				->setName('run')
				->setDescription('Run Meme project')
//				->addArgument(
//						'name',
//						InputArgument::OPTIONAL,
//						'Who do you want to greet?'
//				)
				->addOption(
						'env',
						"e",
						InputOption::VALUE_REQUIRED,
						'Name of environment to run'
				)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$env = $input->getOption("env");
		if (!$env)
			throw new \Exception("You should set an environment name");

		$configDir = getcwd() . "/.meme";
		$env = $configDir . "/{$env}.php";

		$project = new Project("name from config", "start");
		include $env;
		$project->run("start");
	}
}

