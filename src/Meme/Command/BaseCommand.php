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

use Meme\Output;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
	public $configDir = null;

	protected $checkProject = false;

	protected $isDebug = false;

	protected function initialize(InputInterface $input, OutputInterface $output)
	{
		$this->configDir = getcwd() . '/.meme';

		$style = new OutputFormatterStyle('cyan', null, array("underscore"));
		$output->getFormatter()->setStyle('targetHeader', $style);

		$style = new OutputFormatterStyle('yellow');
		$output->getFormatter()->setStyle('taskHeader', $style);

		$style = new OutputFormatterStyle('white');
		$output->getFormatter()->setStyle('mainHeader', $style);



//		$formatter = new OutputFormatter(true);
//		$formatter->setStyle("header", new OutputFormatterStyle('blue'));
//
//		$output->setFormatter($formatter);
		Output::setOutputInterface($output);


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

