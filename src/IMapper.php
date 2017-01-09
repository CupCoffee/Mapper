<?php

namespace Reify;

use Reify\Map\MapObject;

interface IMapper
{
	/**
	 * Maps data to the given class
	 * @param mixed $data
	 * @param MapObject $class
	 * @return mixed;
	 */
	public function map($data, $class);

	/**
	 * Maps a collection of the given class
	 * @param  mixed $data
	 * @param  MapObject $class
	 * @return mixed
	 */
	public function mapArray($data, $class);
}
