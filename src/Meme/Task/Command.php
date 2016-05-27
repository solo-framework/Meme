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
	public $process = null;

	protected $result = null;

	protected $error = null;


	public $command = "";
	public $cwd = null;
	public $ignoreError = false;
	public $verbose = true;

	/**
	 * @var array
	 */
	public $env = null;

	public $input = null;

	public $timeout = 60;
	public $options = array();

	/***
	 * True if error occurred
	 *
	 * @var bool
	 */
	public $isError = false;
	public $exitStatusCode = 0;


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
	public function __construct($command = "", $cwd = null, $ignoreError = false, $verbose = true, array $env = null, $input = null, $timeout = 60, array $options = array())
	{
		$this->command = $command;
		$this->cwd = realpath($cwd);
		$this->ignoreError = $ignoreError;
		$this->verbose = $verbose;
		$this->env = $env;
		$this->input = $input;
		$this->timeout = $timeout;
		$this->options = $options;
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

	public function run()
	{
		$this->process = new Process($this->command, $this->cwd, $this->env, $this->input, $this->timeout, $this->options);

		Output::taskHeader("Start Command task");
		Output::comment("executing a command '{$this->command}'");

		$this->exitStatusCode = $this->process->run(function($a, $b){

			if ($this->verbose)
				Output::info($b);
		});

		if (!$this->process->isSuccessful())
		{
			$this->isError = true;
			if (!$this->ignoreError)
				throw new \Exception($this->process->getErrorOutput());
			else
				$this->error = $this->process->getErrorOutput();
		}


		$this->result = $this->process->getOutput();
		return true;
	}

	/**
	 * @param string $command
	 *
	 * @return $this
	 */
	public function setCommand($command)
	{
		$this->command = $command;
		return $this;
	}

	/**
	 * @param null|string $cwd
	 *
	 * @return $this
	 */
	public function setCwd($cwd)
	{
		$this->cwd = $cwd;
		return $this;
	}

	/**
	 * @param boolean $ignoreError
	 *
	 * @return $this
	 */
	public function setIgnoreError($ignoreError)
	{
		$this->ignoreError = $ignoreError;
		return $this;
	}

	/**
	 * @param boolean $verbose
	 *
	 * @return $this
	 */
	public function setVerbose($verbose)
	{
		$this->verbose = $verbose;
		return $this;
	}

	/**
	 * @param array $env
	 *
	 * @return $this
	 */
	public function setEnv($env)
	{
		$this->env = $env;
		return $this;
	}

	/**
	 * @param null $input
	 *
	 * @return $this
	 */
	public function setInput($input)
	{
		$this->input = $input;
		return $this;
	}

	/**
	 * @param int $timeout
	 *
	 * @return $this
	 */
	public function setTimeout($timeout)
	{
		$this->timeout = $timeout;
		return $this;
	}

	/**
	 * @param array $options
	 *
	 * @return $this
	 */
	public function setOptions($options)
	{
		$this->options = $options;
		return $this;
	}
}

