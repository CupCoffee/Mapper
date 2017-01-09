<?php

namespace Reify\Data;

use Reify\Map\MapObject;

class JsonMapper extends ArrayMapper
{
	/**
	 * @param array $data
	 * @param MapObject $object
	 * @return mixed
	 */
	public function map($data, $object)
	{
		$decodedData = $this->decodeData($data);

		return parent::map($decodedData, $object);
	}

	public function mapArray($data, $object)
	{
		$decodedData = $this->decodeData($data);

		return parent::mapArray($decodedData, $object);
	}

	private function decodeData($data)
	{
		if (!is_string($data)) {
			throw new \InvalidArgumentException('Expected json to be string');
		}

		$decodedData = json_decode($data);

		if (!$decodedData) {
			throw new \InvalidArgumentException(json_last_error_msg());
		}

		return $decodedData;
	}
}
