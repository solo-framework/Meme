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


use Meme\Output;
use Meme\Types\FileSet;
use Symfony\Component\Filesystem\Filesystem;

class Chmod extends Task
{
	public function __construct($target, $mode, $recursive = false, $umask = 0000)
	{
		Output::taskHeader("Start Chmod task");

		try
		{
			if ($target instanceof FileSet)
				$target = $target->getFiles(true);
			else
				$target = (array)$target;

			$fs = new Filesystem();
			array_map(function ($item) use($mode, $recursive){
				$r = "";
				if ($recursive)
					$r = "recursive";

				Output::info("Change file mode on '{$item}' to " . vsprintf("%o", $mode) . " ({$r})" );
			}, $target);


			$fs->chmod($target, $mode, $umask, $recursive);
		}
		catch (\Exception $e)
		{
			Output::error($e->getMessage());
		}
	}
}