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

use Meme\Output;
use Meme\Types\FileSet;
use Symfony\Component\Filesystem\Filesystem;

class Copy extends Task
{
	public function __construct($target, $destination, $overwrite = true)
	{
		Output::taskHeader("Start Copy task");

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
				// пустые каталоги копировать не получается, просто создаем
				if (is_dir($file))
				{
//					Output::info(">> Creating directory '{$file}'");
					$fs->mkdir($toDir . $file);
					continue;
				}

				$res = $toDir . ltrim($file, "\/");
				$fs->copy($file, $res);
			}

			$cnt = count($target);
			Output::info("{$cnt} items were copied into directory '{$toDir}'");
		}
		catch (\Exception $e)
		{
			Output::error($e->getMessage());
		}
	}
}