<?php
/**
 * Поиск и замена подстроки по регулярному выражению в файлах
 * Подробности см. http://php.net/manual/ru/function.preg-replace.php
 *
 * new \Meme\Task\Replace($tmpFile, "/search_string/", "replace_string");
 *
 * PHP version 5
 *
 * @created 08.10.2014 21:05
 * @package
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme\Task;

use Meme\Output;
use Meme\Types\FileSet;

class Replace extends Task
{
	/**
	 * @var array|FileSet|string
	 */
	protected $target;
	/**
	 * @var string
	 */
	protected $regexp;
	/**
	 * @var string
	 */
	protected $replacement;

	/**
	 * @param string|array|FileSet $target Набор файлов
	 * @param string $regexp Регулярное выражение
	 * @param string $replacement Строка для замены
	 */
	public function __construct($target, $regexp, $replacement)
	{
		$this->target = $target;
		$this->regexp = $regexp;
		$this->replacement = $replacement;
	}

	public function run()
	{
		Output::taskHeader("Start Replace task");

		if ($this->target instanceof FileSet)
		{
			$target = $this->target->getFiles(true);
		}
		else
		{
			$target = (array)$this->target;
		}

		foreach ($target as $file)
		{
			if (is_file($file) && is_writable($file))
			{
				$content = file_get_contents($file);
				$content = preg_replace($this->regexp, $this->replacement, $content);
				file_put_contents($file, $content);
			}
			else
			{
				Output::error("Can't do replacement in file {$file}");
			}
		}
	}
}