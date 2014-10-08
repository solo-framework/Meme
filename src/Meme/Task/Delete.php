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

use Meme\Console;
use Meme\Types\FileSet;
use Symfony\Component\Filesystem\Filesystem;

class Delete extends Task
{

	/**
	 * @param string|array|FileSet $target Набор файлов для удаления
	 * @param bool $deleteEmptyDirs
	 */
	public function __construct($target, $deleteEmptyDirs = true)
	{
		//echo ">> Start delete task\n";
		Console::info(">> Start delete task");
		clearstatcache();

		if ($target instanceof FileSet)
		{
			$target = $target->getFiles(true);
		}

		$fs = new Filesystem();
		$fs->remove($target);
	}

}

