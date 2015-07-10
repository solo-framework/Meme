<?php
/**
 * Создание директории
 *
 * new \Meme\Task\Mkdir("../copy", 0777);
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
	/**
	 * @var array|FileSet|string
	 */
	protected $target;
	/**
	 * @var int
	 */
	protected $mode;

	/**
	 * Создание директории
	 *
	 * @param string|array|FileSet $target Набор каталогов для создания
	 * @param int $mode Восьмеричная маска прав доступа
	 */
	public function __construct($target, $mode = 0777)
	{
		$this->target = $target;
		$this->mode = $mode;
	}

	public function run()
	{
		Output::taskHeader("Start Mkdir task");

		if ($this->target instanceof FileSet)
		{
			$target = $this->target->getFiles(true);
		}
		else
		{
			$target = (array)$this->target;
		}

		$fs = new Filesystem();
		$oldumask = umask(0);
		$fs->mkdir($target, $this->mode);
		umask($oldumask);

		array_map(function($el){
			Output::comment("directory '{$el}' has been created with mode " . sprintf("%o", $this->mode));
		}, $target);

		$cnt = count($target);
		Output::info("{$cnt} dirs created");
	}

	/**
	 * @param int $mode
	 *
	 * @return $this
	 */
	public function setMode($mode)
	{
		$this->mode = $mode;
		return $this;
	}
}

