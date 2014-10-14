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

class Mkdir extends Task
{
	public function __construct($target, $mode)
	{
		Output::taskHeader("Start Mkdir task");

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
			Output::info("created dir '{$el}'");
		}, $target);

		$cnt = count($target);
		Output::info("{$cnt} dirs created");
	}
}

