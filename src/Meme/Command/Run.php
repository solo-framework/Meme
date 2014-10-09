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

use Herrera\Annotations\Exception\Exception;
use Meme\Config;
use Meme\Console;
use Meme\Project;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

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

		$envName = $input->getOption("env");
		if (!$envName)
			throw new \Exception("You should set an environment name");

		$configDir = getcwd() . "/.meme";
		$env = $configDir . "/{$envName}.php";
		if (!is_file($env))
		{
			Console::error("You should create build file {$env}");
			exit();
		}
		$yml = $configDir . "/config.yml";


		Console::info("

========================================
   ____ __    ___   ____ __    ___
  / __ `__ \ / _ \ / __ `__ \ / _ \
 / / / / / /(  __// / / / / /(  __/
/_/ /_/ /_/  \__//_/ /_/ /_/  \__/

    PHP build & deployment tool
========================================

		");

		try
		{
			Config::init($yml, $envName);
			$project = new Project(Config::get("name"), "start");

			include $env;
			$project->run("start");
		}
		catch (\Exception $e)
		{
			Console::error("Error: " . $e->getMessage());
		}
	}
}

