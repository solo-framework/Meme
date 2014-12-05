<?php
/**
 * Выполнение консольной команды
 *
 * Пример:
 * new Command("cd /tmp && ls"); // writes a result to console
 *
 * $cmd = new Command("cd /tmp && ls", false);
 * $res = $cmd->getResult();
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

	protected $error = null;

	/**
	 * Выполнение консольной команды
	 * Описание параметров см. https://github.com/symfony/Process
	 *
	 * @param string $command Команда
	 * @param string $cwd Каталог, в контексте которого выполняется команда
	 * @param bool $ignoreError Игнорировать ошибки выполнения команды
	 * @param bool $verbose Отображать результат в процессе выполнения
	 * @param array $env The environment variables or null to inherit
	 * @param null $input The input
	 * @param int $timeout The timeout in seconds or null to disable
	 * @param array $options An array of options for proc_open
	 *
	 * @throws \Exception
	 */
	public function __construct($command, $cwd = null, $ignoreError = false, $verbose = true, array $env = null, $input = null, $timeout = 60, array $options = array())
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
		{
			if (!$ignoreError)
				throw new \Exception($this->process->getErrorOutput());
			else
				$this->error = $this->process->getErrorOutput();
		}


		$this->result = $this->process->getOutput();
	}

	/**
	 * Возвращает результат выполнения команды
	 *
	 * @return null|string
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * Возвращает описание ошибки при выполнении команды
	 *
	 * @return null|string
	 */
	public function getError()
	{
		return $this->error;
	}
}

