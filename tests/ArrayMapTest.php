<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Reify\Data\ArrayMapper;
use Reify\Data\JsonMapper;
use Reify\Reify;
use Reify\Tests\Objects\Person;
use Reify\Tests\Objects\PersonList;

class ArrayMapTest extends TestCase
{
	public function testMapNestedList()
	{
		$data = [
			'items' => [
				[
					'name' => 'Leroy',
					'age'  => '20',
					'gender' => 'male',
					'isAwesome' => true
				],

				[
					'name' => 'Dennis',
					'age'  => '23',
					'gender' => 'female',
					'isAwesome' => false
				]
			],

			'count' => 2
		];

		$personList = Reify::map( new ArrayMapper(), $data )->to( PersonList::class );

		$this->assertInternalType('array', $personList->items);
		$this->assertAttributeContainsOnly(Person::class, 'items', $personList);
	}

	public function testMapAssociativeList()
	{
		$data = [
			'items' => [
				'12331' => [
					'name' => 'John',
					'gender' => 'Male'
				],
				'21312' => [
					'name' => 'Elvira',
					'gender' => 'Female'
				]
			],
			'count' => 2
		];

		$personList = Reify::map(new ArrayMapper(), $data)->to(PersonList::class);

		$this->assertAttributeInternalType('array', 'items', $personList);
		$this->assertAttributeContainsOnly(Person::class, 'items', $personList);
	}
}
