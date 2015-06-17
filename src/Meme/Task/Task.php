<?php
/**
 * Базовый класс для всех задач
 *
 * PHP version 5
 *
 * @package Task
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Task;

abstract class Task
{
	/**
	 * Выполнение действия
	 *
	 * @return mixed
	 */
	public abstract function run();
}

