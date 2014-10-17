<?php
/**
 * Базовый класс для всех классов, описывающих наборы задач.
 *
 * PHP version 5
 *
 * @package Meme
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme;

abstract class TargetDefinition implements ITargetDefinition
{
	protected $fn;

	/**
	 * Задает функцию, описывающую набор задач
	 *
	 * @param mixed $fn
	 */
	public function setFunction($fn)
	{
		$this->fn = $fn;
	}

	/**
	 * Возвращает функцию, описывающую набор задач
	 *
	 * @return mixed
	 */
	public function getFunction()
	{
		return $this->fn;
	}

}

