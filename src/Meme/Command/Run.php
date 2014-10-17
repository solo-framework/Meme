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
				->addOption("debug", "d", InputOption::VALUE_OPTIONAL, "Run in debug mode")
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->isDebug = $input->hasParameterOption(array("-d", "--debug"));
		$envName = $input->getOption("env");
		if (!$envName)
			throw new \Exception("You should set an environment name");

		$configDir = getcwd() . "/.meme";
		$env = $configDir . "/{$envName}.php";
		if (!is_file($env))
		{
			Output::error("You should create build file {$env}");
			exit();
		}
		$yml = $configDir . "/config.yml";

		parent::execute($input, $output);

		try
		{
			Config::init($yml, $envName);
			$project = new Project(Config::get("name"), "start");

			include $env;
			$project->run();
		}
		catch (\Exception $e)
		{
			Output::error("Error: " . $e->getMessage());

			if ($this->isDebug)
			{
				Output::error("\n---------------Error----------------");
				Output::error($e->getTraceAsString());
			}
		}
	}
}

