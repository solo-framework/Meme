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

class Target
{
	public $name = null;
	protected  $fn = null;
	protected $depend = null;

	public function __construct($name, $fn, $depend = null)
	{
		$this->depend = $depend;
		$this->name = $name;
		$this->fn = $fn;
	}

	public function getDepends()
	{
		return array_filter(
				array_map(function($el){
					return trim($el);
				},
				explode(",", $this->depend))
		);
	}

	public function run()
	{
		if ($this->fn)
			return call_user_func($this->fn);
	}
}

