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
use Meme\Types\FileSet;
use Symfony\Component\Filesystem\Filesystem;

class Delete extends Task
{

	/**
	 * @param string|array|FileSet $target Набор файлов для удаления
	 * @param bool $deleteEmptyDirs
	 */
	public function __construct($target, $deleteEmptyDirs = true, $verbose = true)
	{
		Output::taskHeader("Start Delete task");

		if ($target instanceof FileSet)
		{
			$target = $target->getFiles(true);
		}
		else
		{
			$target = (array)$target;
		}

		$fs = new Filesystem();
		$fs->remove($target);

		if ($verbose)
		{
			foreach ($target as $file)
				Output::info("Deleted {$file}");
		}

		$cnt = count($target);
		Output::info("{$cnt} file(s) were deleted");
	}

}

