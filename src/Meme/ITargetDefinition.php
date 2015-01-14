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

interface ITargetDefinition
{
	public function getFunction();
	public function setFunction($fn);
}

