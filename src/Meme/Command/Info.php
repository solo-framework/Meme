<?php
/**
 * Отображает список
 *
 * PHP version 5
 *
 * @package Command
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Command;

use Meme\Config;
use Meme\Output;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class Info extends BaseCommand
{
	protected function configure()
	{
		parent::configure();
		$this
				->setName('info')
				->setDescription('Shows project environments');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);
		$configDir = getcwd() . "/.meme";
		$yml = $configDir . "/config.yml";

		if (!is_file($yml))
		{
			Output::error("Can't open config.yml");
			exit();
		}

		$cnf = Config::read($yml);
		Output::info("You have " . count($cnf) . " env(s):");

		$table = new Table($output);
		$table->setHeaders(array("Environment name", "alias", "Status"));
		$rows = array();

		foreach ($cnf as $k => $v)
		{
			$cnfFile = "{$configDir}/{$k}.php";
			$ok = "";
			if (is_file($cnfFile))
				$ok = "ok (command to run: meme run -e {$k})";
			else
				$ok = "file {$cnfFile} doesn't exist";

			$rows[] = array($v['name'], $k, $ok);

			//Output::info("{$k}: {$v['name']} {$ok}");
		}

		$table->setRows($rows);
		$table->render();
	}
}

