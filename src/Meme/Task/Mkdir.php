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

class Mkdir extends Task
{
	public function __construct($target, $mode)
	{
		Console::info(">> Start Mkdir task");

		if ($target instanceof FileSet)
		{
			$target = $target->getFiles(true);
		}
		else
		{
			$target = (array)$target;
		}

		$fs = new Filesystem();
		$fs->mkdir($target, $mode);

		array_map(function($el){
			Console::info("\tcreated dir '{$el}'");
		}, $target);

		$cnt = count($target);
		Console::info("\t{$cnt} dirs have been created");
	}
}

