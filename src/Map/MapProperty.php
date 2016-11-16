<?php

namespace Mapper\Map;


class MapProperty
{
	const PRIMITIVE_TYPES = [
		"string",
		"bool",
		"boolean",
		"int",
		"integer",
		"float"
	];

	/**
	 * @var MapObject|string
	 */
	private $type;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var boolean
	 */
	private $nullable;

	/**
	 * @var boolean
	 */
	private $collection;

	/**
	 * @var MapObject
	 */
	private $mappedObject;

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param MapObject|string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return boolean
	 */
	public function isNullable()
	{
		return $this->nullable;
	}

	/**
	 * @param boolean $nullable
	 */
	public function setNullable($nullable)
	{
		$this->nullable = $nullable;
	}

	/**
	 * @return boolean
	 */
	public function isCollection()
	{
		return $this->collection;
	}

	/**
	 * @param boolean $collection
	 */
	public function setCollection($collection)
	{
		$this->collection = $collection;
	}

	/**
	 * @param string $type
	 * @return bool
	 */
	public static function isPrimitive($type)
	{
		return in_array($type, self::PRIMITIVE_TYPES);
	}

	/**
	 * @return MapObject
	 */
	public function getMappedObject()
	{
		return $this->mappedObject;
	}

	/**
	 * @param MapObject $mappedObject
	 */
	public function setMappedObject($mappedObject)
	{
		$this->mappedObject = $mappedObject;
	}
}