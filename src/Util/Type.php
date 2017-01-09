<?php

namespace Reify\Util;

class Type
{

    const PRIMITIVE_TYPES = [
		"string",
		"bool",
		"boolean",
		"int",
		"integer",
		"float",
		"array",
		"object"
	];

    /**
     * @param  string $type
     * @return bool
     */
	public static function isPrimitive($type)
	{
		return in_array(strtolower($type), self::PRIMITIVE_TYPES);
	}

    /**
     * @param  string $type
     * @return bool
     */
	public static function isInt($type)
	{
        return in_array(strtolower($type), ["int", "integer"]);
	}

    /**
     * @param  string $type
     * @return bool
     */
    public static function isFloat($type)
    {
        return strtolower($type) == "float";
    }

    /**
     * @param  string $type
     * @return bool
     */
	public static function isBool($type)
	{
		return in_array(strtolower($type), ["bool", "boolean"]);
	}

    /**
     * @param  string $type
     * @return bool
     */
	public static function isString($type)
	{
		return strtolower($type) == "string";
	}

    /**
     * @param  string $type
     * @return bool
     */
    public static function isArray($type)
    {
        return strtolower($type) == "array";
    }

    /**
     * @param  string $type
     * @return bool
     */
    public static function isObject($type)
    {
        return strtolower($type) == "object";
    }


	/**
	 * Casts the value to given type
	 * @param $value
	 * @param $type
	 * @return mixed
	 */
	public static function castToType($value, $type)
	{
		if (self::isBool($type)) {
			return (bool) $value;
		}

		if (self::isInt($type)) {
			return (int) $value;
		}

        if (self::isFloat($type)) {
			return (float) $value;
		}

		if (self::isString($type)) {
			return (string) $value;
		}

        if (self::isArray($type)) {
            return (array) $value;
        }

        if (self::isObject($type)) {
            return (object) $value;
        }

		return $value;
	}
}
