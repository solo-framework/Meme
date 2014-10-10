<?php
/**
 * Выполнение команды на удаленном сервере
 *
 * 	$ssh = new SshConnection("host", "user", "password");
 *	new SshCommand($ssh, "ls -l", true);
 *	new SshCommand($ssh, "uname -a", true);
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

use Meme\Console;
use Meme\Task\Task;

class SshCommand extends Task
{
	/**
	 * Выполнение команды на удаленном сервере
	 *
	 * @param SshConnection $conn Ссылка на соединение
	 * @param string $command Команда
	 * @param bool $display Выводить результат сразу или возвращать в переменную
	 *
	 * @return string | null
	 */
	public function __construct(SshConnection $conn, $command, $display = false)
	{
		try
		{
			Console::debug(">>>> executing command: {$command}");
			$connection = $conn->getConnection();
			$stream = ssh2_exec($connection, $command);
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

			if ($display)
			{
				print $result;
				return $result;
			}
			else
			{
				return $result;
			}
		}
		catch (\Exception $e)
		{
			Console::error($e->getMessage());
		}
	}
}

