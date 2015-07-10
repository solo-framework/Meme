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

class ReplaceInString extends Task
{
	/**
	 * @var
	 */
	protected $string;

	protected $replacement;

	protected $regexp;

	/**
	 * @param string $string Исходный тескт
	 * @param mixed $regexp Регулярное выражение
	 * @param mixed $replacement Строка для замены
	 */
	public function __construct($string, $regexp, $replacement)
	{
		$this->regexp = $regexp;
		$this->replacement = $replacement;
		$this->string = $string;
	}
	/**
	 * Выполнение действия
	 *
	 * @return mixed
	 */
	public function run()
	{
		Output::taskHeader("Start ReplaceInText task");
		$res = preg_replace($this->regexp, $this->replacement, $this->string);
		if (null === $res)
		{
			$last = error_get_last();
			if ($last)
				Output::error($last["message"]);
			else
				Output::error("Error in ReplaceInString");

			return $this->string;
		}
		else
		{
			return $res;
		}
	}
}

