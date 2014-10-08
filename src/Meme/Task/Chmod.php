<?php
/**
 *
 *
 * PHP version 5
 *
 * @created 08.10.2014 22:12
 * @package
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme\Task;


use Meme\Console;
use Meme\Types\FileSet;
use Symfony\Component\Filesystem\Filesystem;

class Chmod extends Task
{
	public function __construct($target, $mode, $umask = 0000, $recursive = false)
	{
		Console::info(">> Start Chmod task");
		clearstatcache();

		try
		{

			if ($target instanceof FileSet)
				$target = $target->getFiles(true);
			else
				$target = (array)$target;

			$fs = new Filesystem();
			$fs->chmod($target, $mode, $umask, $recursive);
		}
		catch (\Exception $e)
		{
			Console::error($e->getMessage());
		}
	}
}