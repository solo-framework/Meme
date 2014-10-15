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

abstract class TargetDefinition implements ITargetDefinition
{
	protected $fn;

	/**
	 * @param mixed $fn
	 */
	public function setFunction($fn)
	{
		$this->fn = $fn;
	}

	/**
	 * @return mixed
	 */
	public function getFunction()
	{
		return $this->fn;
	}

}

