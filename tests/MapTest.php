<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Reify\Data\ArrayMapper;
use Reify\Data\JsonMapper;
use Reify\Reify;
use Reify\Tests\Objects\Family;
use Reify\Tests\Objects\Person;
use Reify\Tests\Objects\PersonList;

class MapTest extends TestCase {
	public function testMapObject() {
		$data = [
			'name' => 'Leroy',
			'age'  => 20,
			'gender' => 'male',
			'isAwesome' => true
		];

		$person = Reify::map( new ArrayMapper(), $data )->to( Person::class );

		$this->assertInstanceOf(Person::class, $person);

		$this->assertAttributeInternalType('string', 'name', $person);
		$this->assertAttributeInternalType('string', 'gender', $person);
		$this->assertAttributeInternalType('integer', 'age', $person);
		$this->assertAttributeInternalType('boolean', 'isAwesome', $person);
	}

	public function testMapNestedObject()
	{
		$data = [
			'mom' => [
				'name' => 'Nancy Lumbridge',
				'age' => 46,
				'gender' => 'female'
			],

			'dad' => [
				'name' => 'Vin Diesel',
				'age' => 51,
				'gender' => 'male'
			],

			'son' => [
				'name' => 'Michael Cera',
				'age' => 15,
				'gender' => 'male'
			],

			'daughter' => [
				'name' => 'Seth Rogen',
				'age' => 11,
				'gender' => 'female'
			],
		];

		$family = Reify::map(new ArrayMapper(), $data)->to(Family::class);

		$this->assertContainsOnly(Person::class, (array) $family);
	}
}