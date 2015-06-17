<?php
/**
 * Выполнение команды на удаленном сервере
 *
 * 	$ssh = new SshConnection("host", 22);
 *  $ssh->authPublicKey("user", "./run.pub", "./run.priv");
 *	new SshCommand($ssh, "ls -l", true);
 *	new SshCommand($ssh, "uname -a", true);
 *  new SshCommand($ssh, SshCommand::sudoCommand("mkdir /newdir")); // от имени суперпользователя
 *
 *  $res = new SshCommand($ssh, "cd / && ls -l");
 *  print $res;
 *
 *  Выводит результат выполнения команд
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Task\SSH;

use Meme\Output;
use Meme\Task\Task;

class SshCommand extends Task
{
	/**
	 * @var SshConnection
	 */
	protected $conn;

	/**
	 * @var string
	 */
	protected $command;

	/**
	 * @var bool
	 */
	protected $display;

	/**
	 * Выполнение команды на удаленном сервере
	 *
	 * @param SshConnection $conn Ссылка на соединение
	 * @param string $command Команда
	 * @param bool $display Выводить результат сразу или возвращать в переменную
	 *
	 */
	public function __construct(SshConnection $conn, $command, $display = false)
	{
		$this->conn = $conn;
		$this->command = $command;
		$this->display = $display;
	}

	/**
	 * Генерирует команду, которую можно выполнить
	 * в контексте суперпользователя
	 *
	 * @param string $cmd Команда
	 * @param string $password Пароль суперпользователя
	 *
	 * @return string
	 */
//	public static function sudoCommand($cmd, $password)
//	{
//		return "echo '{$password}' | sudo -S " . $cmd;
//	}

	/**
	 * Генерирует команду, которую можно выполнить
	 * в контексте суперпользователя
	 *
	 * @param $password
	 *
	 * @return $this
	 */
	public function sudo($password)
	{
		$this->command = "echo '{$password}' | sudo -S " . $this->command;
		return $this;
	}

	/**
	 * Выполнение действия
	 *
	 * @return mixed
	 */
	public function run()
	{
		try
		{
			Output::taskHeader("Start SSHCommand task");
			Output::comment("executing command: {$this->command}");
			$connection = $this->conn->getConnection();
			$stream = ssh2_exec($connection, $this->command);
			if (!$stream)
				throw new \Exception("Could not execute command!");

			stream_set_blocking($stream, true);
			$result = stream_get_contents($stream);

			if (!strlen($result))
			{
				$stderrStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
				stream_set_blocking($stderrStream, true);
				$result = stream_get_contents($stderrStream);
			}

			fclose($stream);
			if (isset($stderrStream))
				fclose($stderrStream);

			if ($this->display)
			{
				Output::info($result);
				return $result;
			}
			else
			{
				return $result;
			}
		}
		catch (\Exception $e)
		{
			Output::error($e->getMessage());
		}
	}

	/**
	 * @param boolean $display
	 *
	 * @return $this
	 */
	public function setDisplay($display)
	{
		$this->display = $display;
		return $this;
	}
}

