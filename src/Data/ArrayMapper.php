<?php

namespace Reify\Data;


use Reify\IMapper;
use Reify\Map\MapObject;
use Reify\Map\MapProperty;
use Reify\Util\Type;

class ArrayMapper implements IMapper
{
	/**
	 * @param array $data
	 * @param MapObject $class
	 * @return mixed
	 */
	public function map($data, $class)
	{
		$object = $class->getInstance();

		foreach ($data as $propertyName => $value) {
			if (property_exists($object, $propertyName) && $property = $class->getProperty($propertyName)) {
				$object->$propertyName = $this->mapProperty($property, $value);
			}
		}

		return $object;
	}

	public function mapArray($data, $class)
	{
		$objects = [];

		foreach($data as $item) {
			$objects[] = $this->map($item, $class);
		}

		return $objects;
	}

	/**
	 * @param MapProperty $property
	 * @param mixed $data
	 *
	 * @return mixed mappedObject
	 * @internal param mixed $value
	 *
	 */
	private function mapProperty(MapProperty $property, $data)
	{
		if ($property->isCollection()) {
			$items = [];
			foreach((array) $data as $element) {
				$items[] = $this->mapValue($property, $element);
			}

			return $items;
		} else {
			return $this->mapValue($property, $data);
		}
	}

	/**
	 * @param MapProperty $property
	 * @param $data
	 *
	 * @return mixed
	 */
	private function mapValue(MapProperty $property, $data)
	{
		if (Type::isPrimitive($property->getType())) {
			return Type::castToType($data, $property->getType());
		} else {
			$object = $property->getMappedObject()->getInstance();

			foreach((array) $data as $key => $value) {
				$objectProperty = $property->getMappedObject()->getProperty($key);

				if (property_exists($object, $key)) {
					$object->$key = $this->mapProperty($objectProperty, $value);
				}
			}

			return $object;
		}
	}
}