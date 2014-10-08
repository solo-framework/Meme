<?php
/**
 *
 *
 * PHP version 5
 *
 * @created 08.10.2014 22:39
 * @package
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme\Task;

use Meme\Console;
use Meme\Types\FileSet;
use Symfony\Component\Filesystem\Filesystem;

class Copy extends Task
{
	public function __construct($target, $destination, $overwrite = true)
	{
		Console::info(">> Start Copy task");

		try
		{
			$fs = new Filesystem();
			if ($target instanceof FileSet)
				$target = $target->getFiles(true);
			else
				$target = (array)$target;

			$toDir = trim($destination) . DIRECTORY_SEPARATOR;
			foreach ($target as $file)
			{
				$res = $toDir . ltrim($file, "\/.");
				$fs->copy($file, $res);
			}

			$cnt = count($target);
			Console::info(">> {$cnt} was copied into directory '{$toDir}'");
		}
		catch (\Exception $e)
		{
			Console::error($e->getMessage());
		}

	}
}