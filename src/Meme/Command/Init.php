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

			$yml = $this->configDir . "/config.yml";
			$envFile = $this->configDir . "/{$env}.php";
			touch($yml);
			touch($envFile);

$cnfDummy = <<<EOT
# конфигурационный файл Meme-проекта
{$env}:

    name: environment description here

    # например, подключение к БД
    mongo:
        username: root
        password: password
        isDebug: true
        dsn: mysql:host=hostname;dbname=dbname
EOT;

		file_put_contents($yml, $cnfDummy);


$envDummy = <<<EOT
<?php

use Meme\Console;
use Meme\Project;
use Meme\Types;
use Meme\Target;

/**
 * @var \$project Project
 */

\$project->setStartTask("start");

//
// Write your targets and task below
//

// for example
\$startTarget = new Target("start", function(){

	Console::info("Hello, world!");

}/*, add dependencies here*/);


// don't forget to add your targets to the project
\$project->addTarget(\$startTarget);


EOT;

			file_put_contents($envFile, $envDummy);
		}

		$o->writeln("<info>Project has been successfully created</info>");
		return 0;
	}

}

