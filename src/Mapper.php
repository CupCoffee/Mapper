<?php

namespace Reify;

use Exception;
use Reify\Map\MapObject;

class Mapper
{
	/**
	 * @var IMapper
	 */
	private $mapper;

	/**
	 * @var mixed
	 */
	private $data;

	/**
	 * @var bool
	 */
	private $mapArray = false;


	public static function map(IMapper $mapper, $data)
	{
		return (new Mapper())
			->setMapper($mapper)
			->setData($data);
	}

	public static function mapArray(IMapper $mapper, $data)
	{
		return (new Mapper())
			->setMapArray(true)
			->setMapper($mapper)
			->setData($data);
	}

	public function to($class)
	{
		if (!isset($this->mapper)) {
			throw new Exception("Undefined mapper interface");
		}

		if ($this->mapArray) {
			return $this->mapper->mapArray($this->data, MapObject::map($class));
		} else {
			return $this->mapper->map($this->data, MapObject::map($class));
		}
	}

	/**
	 * @param mixed $mapper
	 * @return Mapper
	 */
	public function setMapper(IMapper $mapper)
	{
		$this->mapper = $mapper;
		return $this;
	}

	/**
	 * @param mixed $data
	 * @return Mapper
	 */
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * @param bool $mapArray
	 * @return Mapper
	 */
	public function setMapArray($mapArray)
	{
		$this->mapArray = $mapArray;
		return $this;
	}
}
