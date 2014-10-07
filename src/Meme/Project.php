<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
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

	protected $startTask;

	public function __construct($name, $startTask)
	{
		$this->name = $name;
		$this->startTask = $startTask;
	}

	public function addTarget(Target $target)
	{
		$this->targets[$target->name] = $target;
	}

	public function run($name)
	{
		echo "\n------------ Start Meme project '{$this->name}' ------------\n";
		$this->runRecursive($this->getTargetByName($name));
		echo "\n------------ Finish Meme project '{$this->name}' ------------\n";
	}

	protected function runRecursive(Target $target)
	{
		$deps = $target->getDepends();
		if ($deps)
		{
			foreach ($deps as $depTarget)
				$this->runRecursive($this->getTargetByName($depTarget));
		}
		$target->run();
	}

	protected function getTargetByName($name)
	{
		if(!array_key_exists($name, $this->targets))
			throw new \Exception("Target '{$name}' is not defined");
		else
			return $this->targets[$name];
	}
}

