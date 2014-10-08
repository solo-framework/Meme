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

use Symfony\Component\Filesystem\Filesystem;

class Delete extends Task
{

	public function __construct($files, $deleteEmptyDirs = true)
	{
		echo ">> Start delete task\n";
		clearstatcache();
		$files = (array)$files;
		$fs = new Filesystem();
		$fs->remove($files);
	}

	public function run()
	{
		// TODO: Implement run() method.
	}
}

