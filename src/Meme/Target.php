<?php
/**
 * Набор задач
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme;

class Target
{
	public $name = null;
	protected  $fn = null;
	protected $depend = null;

	/**
	 * Конструктор
	 *
	 * @param string $name
	 * @param callable|ITargetDefinition $fn Анонимная функция
	 * @param string $depend Список наборов задач, которые должны быть
	 *                       выполнены перед этим набором
	 */
	public function __construct($name, $fn, $depend = null)
	{
		$this->depend = $depend;
		$this->name = $name;

		if ($fn instanceof ITargetDefinition)
			$this->fn = $fn->getFunction();
		else
			$this->fn = $fn;
	}

	/**
	 * Возвращает список зависимостей этого набора задач
	 *
	 * @return array
	 */
	public function getDepends()
	{
		return array_filter(
				array_map(function($el){
					return trim($el);
				},
				explode(",", $this->depend))
		);
	}

	/**
	 * Выполенение набора задач
	 *
	 * @return mixed
	 */
	public function run()
	{
		if ($this->fn)
			return call_user_func($this->fn);
		else
			return null;
	}
}

