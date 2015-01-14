<?php
/**
 *
 *
 * PHP version 5
 *
 * @created 07.10.2014 20:49
 * @package
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Types;


class FileSetFilter extends \RecursiveFilterIterator
{

	protected $filters = array();


	public function setFilters($filters)
	{
		$this->filters = $filters;
	}

	/**
	 * Check whether the current element of the iterator is acceptable
	 *
	 * @link http://php.net/manual/en/filteriterator.accept.php
	 * @return bool true if the current element is acceptable, otherwise false.
	 */
	public function accept()
	{

	}
}