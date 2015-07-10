<?php
/**
 * Удаление или переименование файла или каталога
 * Remove and rename a file or dir
 *
 * new \Meme\Task\Move("../test/", "./newdir/");
 *
 * PHP version 5
 *
 * @created 09.10.2014 21:56
 * @package Task
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme\Task;


use Meme\Output;
use Symfony\Component\Filesystem\Filesystem;

class Move extends Task
{
	/**
	 * @var string
	 */
	protected $from;
	/**
	 * @var string
	 */
	protected $to;

	/**
	 * Удаление или переименование файла или каталога
	 *
	 * @param string $from Имя файла или каталога
	 * @param string $to Путь назначения
	 */
	public function __construct($from, $to)
	{
		$this->from = $from;
		$this->to = $to;
	}

	public function run()
	{
		Output::info(">> Start Move\\Rename task");
		Output::comment("\tMove\\Rename {$this->from} to {$this->to}");
		$fs = new Filesystem();
		$fs->rename($this->from, $this->to);
	}
}