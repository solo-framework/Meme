<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Task;

use Meme\Output;
use Symfony\Component\Process\Process;

class Command extends Task
{
	/**
	 * @var Process
	 */
	protected $process = null;

	protected $result = null;

	public function __construct($command, $cwd = null, $verbose = true, array $env = null, $input = null, $timeout = 60, array $options = array())
	{
		$cwd = realpath($cwd);
		$this->process = new Process($command, $cwd, $env, $input, $timeout, $options);

		Output::taskHeader("Start Command");
		Output::comment("Executing a command '{$command}'");
		$this->process->run(function($a, $b) use ($verbose){

			if ($verbose)
				Output::info($b);
		});

		if (!$this->process->isSuccessful())
			throw new \RuntimeException($this->process->getErrorOutput());

		$this->result = $this->process->getOutput();
	}

	public function getResult()
	{
		return $this->result;
	}
}

