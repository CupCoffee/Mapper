<?php

namespace Reify\Map;

use Exception;
use ReflectionClass;
use ReflectionProperty;
use Reify\Util\Type;

class MapObject
{
	private static $resolvedClasses = [];
	private static $resolvedTypes = [];

	const PROPERTY_TYPE_PATTERN = "/@var\\s*([^\\s]+)/";

	private $class;
	private $properties = [];

	/**
	 * MapObject constructor.
	 * @param string $class
	 */
	public function __construct($class)
	{
		self::$resolvedClasses[$class] = $this;
		$this->class = $class;

		$reflector = new ReflectionClass($class);
		$properties = $reflector->getProperties();

		foreach($properties as $property) {
			try {
				$resolvedProperty = $this->resolveProperty($reflector, $property);
			} catch (Exception $e) {
				echo $e->getMessage() . PHP_EOL;
				continue;
			}

			if (!Type::isPrimitive($resolvedProperty->getType())) {
				$resolvedProperty->setMappedObject(MapObject::map($resolvedProperty->getType(), $property->getName()));
			}

			$this->addProperty($property->getName(), $resolvedProperty);
		}
	}

	public static function map($class, $key = null)
	{
		$class = trim($class, '/\\');

		// Check if we have already indexed this type, if not add an empty record
		if (!isset(self::$resolvedTypes[$class])) {
			self::$resolvedTypes[$class] = [];
		}

		// If there's a key given, check if there is a type mapped to this key, if there is return it otherwise we have yet to resolve this type
		if ($key) {
			if (isset(self::$resolvedTypes[$class][$key])) {
				$resolvedType = self::$resolvedTypes[$class][$key];
			} else {
				// Check if this class has already been resolved, if it has, get it from the cache array
				if (isset(self::$resolvedClasses[$class])) {
					$resolvedType = self::$resolvedClasses[$class];
				} else {
					$resolvedType = new MapObject($class);
				}

				self::$resolvedTypes[$class][$key] = $resolvedType;
			}
		} else {
			$resolvedType = new MapObject($class);
		}

		return $resolvedType;
	}

	public function addProperty($key, $type)
	{
		$this->properties[$key] = $type;
	}

	public function getProperty($name)
	{
		if (isset($this->properties[$name])) {
			return $this->properties[$name];
		}

		return null;
	}

	public function getInstance()
	{
		return new $this->class;
	}

	private function resolveProperty(ReflectionClass $class, ReflectionProperty $property)
	{
		$propertyName = $property->getName();
		$docComment = $property->getDocComment();

		$matches = [];
		preg_match(MapObject::PROPERTY_TYPE_PATTERN, $docComment, $matches);

		if ($matches) {
			$typeString = $matches[1];

			$types = explode('|', $typeString);

			$property = new MapProperty();
			$property->setName($propertyName);

			foreach($types as $type) {
				if ($type == "null") {
					$property->setNullable(true);
					continue;
				}

				if (strpos($type, "[]") !== false) {
					$type = str_replace("[]", "", $type);
					$property->setCollection(true);
				}

				if (Type::isPrimitive(strtolower($type))) {
					$property->setType(strtolower($type));
				} else {
					$resolvedClass = $this->resolveType($class->getNamespaceName(), $type);
					$property->setType($resolvedClass);
				}
			}

			return $property;
		}

		throw new Exception("Property " . $property->getName() . " in class $this->class, couldn't be resolved");
	}

	private function resolveType($namespace, $type)
	{
		if (strpos($type, $namespace) !== false && class_exists($type)) {
			return $type;
		}

		$absoluteClassName = "$namespace\\$type";

		// If the given type is in the same namespace
		if (class_exists($absoluteClassName)) {
			return $absoluteClassName;
		}

		throw new Exception("Type $type couldn't be resolved");
	}
}
