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
use Meme\Output;
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
		parent::configure();
		$this
				->setName('run')
				->setDescription('Run Meme project')
				->addOption(
						'env',
						"e",
						InputOption::VALUE_REQUIRED,
						'Name of environment to run'
				)
				->addOption(
						"add",
						"a",
						InputOption::VALUE_OPTIONAL,
						"Additional config file"
				)
				->addOption("debug", "d", InputOption::VALUE_OPTIONAL, "Run in debug mode")
				->addOption("target", "t", InputOption::VALUE_OPTIONAL, "Execute a concrete target")
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->isDebug = $input->hasParameterOption(array("-d", "--debug"));
		$envName = $input->getOption("env");
		if (!$envName)
			throw new \Exception("You should set an environment name");

		$targetName = $input->getOption("target");

		$configDir = getcwd() . "/.meme";
		$env = $configDir . "/{$envName}.php";
		if (!is_file($env))
		{
			Output::error("You should create build file {$env}");
			exit();
		}

		$additionalFile = $input->getOption("add");
		$additionalConfig = null;
		if ($additionalFile && !is_file($additionalFile))
		{
			Output::error("can't read an additional config '{$additionalFile}'");
			exit();
		}

		//print_r($additionalFile);

		$yml = $configDir . "/config.yml";

		parent::execute($input, $output);

		$project = null;
		try
		{
			Config::init($envName, $yml, $additionalFile);
			$project = new Project(Config::get("name"));

			include $env;
			$project->run($targetName);
			return 0;
		}
		catch (\Exception $e)
		{
			Output::error("Error: " . $e->getMessage());

			if ($this->isDebug)
			{
				Output::error("\n---------------Error----------------");
				Output::error($e->getTraceAsString());
			}

			$project->runOnError($e);

			return 1;
		}
	}
}

