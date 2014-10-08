<?php
/**
 *
 *
 * PHP version 5
 *
 * @created 08.10.2014 21:05
 * @package
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme\Task;

use Meme\Console;
use Meme\Types\FileSet;

class Replace extends Task
{
	public function __construct($target, $regexp, $replacement)
	{
		Console::info(">> Start replace task");
		clearstatcache();

		//$pattern = "/{$pattern}/";

		if ($target instanceof FileSet)
		{
			$target = $target->getFiles(true);
		}
		else
		{
			$target = (array)$target;
		}

		foreach ($target as $file)
		{
			if (is_file($file) && is_writable($file))
			{
				$content = file_get_contents($file);
				$content = preg_replace($regexp, $replacement, $content);
				file_put_contents($file, $content);
			}
			else
			{
				Console::error("Can't do replacement in file {$file}");
			}
		}
	}
}