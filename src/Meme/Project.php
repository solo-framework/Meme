<?php
/**
 * Это класс для запуска задач, описанных в сборочном скрипте
 *
 * PHP version 5
 *
 * @package Meme
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme;

class Project
{
	/**
	 * @var Target[]
	 */
	protected $targets = array();

	protected $name;

	protected $startTarget = "default";

	/**
	 * Конструктор
	 *
	 * @param string $name Название проекта
	 */
	public function __construct($name)
	{
		$this->name = $name;

	}

	/**
	 * Установка задачи, выполняемой по-умолчанию
	 *
	 * @param string $startTask Имя задачи, выполняемой по-умолчанию
	 *
	 * @return void
	 */
	public function setStartTarget($startTask)
	{
		$this->startTarget = $startTask;
	}

	/**
	 * Добавление набора задач в проект
	 *
	 * @param Target $target Набор задач
	 */
	public function addTarget(Target $target)
	{
		$this->targets[$target->name] = $target;
	}

	/**
	 * Выполнение всех наборов задач, описанных в сборочном скрипте
	 *
	 * @param string $name Имя задачи по-умолчанию
	 */
	public function run($name = null)
	{
		if (!$name)
			$name = $this->startTarget;
print_r($name);
		clearstatcache();
		$start = microtime(true);

		Output::mainHeader("Start Meme project '{$this->name}'\n");

		$this->runRecursive($this->getTargetByName($name));
		$time = round(microtime(true) - $start, 3);

		Output::mainHeader("\nMeme has finished building the project '{$this->name}', it took {$time} sec. \n");
	}

	/**
	 * Запуск наборов задач рекурсивно
	 *
	 * @param Target $target Набор задач
	 */
	protected function runRecursive(Target $target)
	{
		$deps = $target->getDepends();
		if ($deps)
		{
			foreach ($deps as $depTarget)
				$this->runRecursive($this->getTargetByName($depTarget));
		}
		Output::targetHeader("run target > '{$target->name}':");
		Output::targetHeader("");
		$target->run();
	}

	/**
	 * Возвращает набор задач по имени
	 *
	 * @param $name
	 *
	 * @return Target
	 * @throws \Exception
	 */
	protected function getTargetByName($name)
	{
		if(!array_key_exists($name, $this->targets))
			throw new \Exception("Target '{$name}' is not defined");
		else
			return $this->targets[$name];
	}
}

