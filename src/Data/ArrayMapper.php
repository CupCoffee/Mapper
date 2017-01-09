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

		if (is_object($data) || $this->isAssoc($data)) {
			foreach ($data as $propertyName => $value) {
				$this->mapProperty($class->getProperty($propertyName), $value, $object);
			}

			return $object;
		} else {
			$objects = [];

			foreach($data as $item) {
				$object = $class->getInstance();

				foreach($item as $propertyName => $value) {
					$this->mapProperty($class->getProperty($propertyName), $value, $object);
				}

				$objects[] = $object;
			}

			return $objects;
		}
	}

	/**
	 * @param MapProperty $property
	 * @param MapObject $object
	 */
	private function mapProperty($property, $value, &$object)
	{
		if ($property) {
			$propertyName = $property->getName();
			$propertyType = $property->getType();

			if (is_array($value)) {
				foreach($value as $item) {
					$this->mapProperty($property, $item, $object);
				}
			} else {
				if (Type::isPrimitive($propertyType)) {
					$object->$propertyName = Type::castToType($value, $propertyType);
				} else {
					$mapObject = $property->getMappedObject();
					$propertyObject = $mapObject->getInstance();

					foreach($value as $name => $propertyValue) {
						$this->mapProperty($mapObject->getProperty($name), $propertyValue, $propertyObject);
					}

					if ($property->isCollection()) {
						if (!isset($object->$propertyName)) {
							$object->$propertyName = [];
						}

						$object->{$propertyName}[] = $propertyObject;
					}  else {
						$object->$propertyName = $propertyObject;
					}
				}
			}
		}
	}

	private function isAssoc($array)
	{
		if ([] === $array) return false;
		return array_keys($array) !== range(0, count($array) - 1);
	}
}
