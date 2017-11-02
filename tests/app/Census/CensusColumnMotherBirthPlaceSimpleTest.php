<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2017 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace Fisharebest\Webtrees\Census;

use Mockery;

/**
 * Test harness for the class CensusColumnMotherBirthPlaceSimple
 */
class CensusColumnMotherBirthPlaceSimpleTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Delete mock objects
	 */
	public function tearDown() {
		Mockery::close();
	}

	/**
	 * Get place mock.
	 *
	 * @param string $place Gedcom Place
	 *
	 * @return \Fisharebest\Webtrees\Place
	 */
	private function getPlaceMock($place)
	{
		$placeParts = explode(', ', $place);

		$placeMock = Mockery::mock('\Fisharebest\Webtrees\Place');
		$placeMock->shouldReceive('getGedcomName')->andReturn($place);
		$placeMock->shouldReceive('lastPart')->andReturn(end($placeParts));

		return $placeMock;
	}

	/**
	 * @covers \Fisharebest\Webtrees\Census\CensusColumnMotherBirthPlaceSimple
	 * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
	 */
	public function testKnownStateAndTown() {
		$father = Mockery::mock('Fisharebest\Webtrees\Individual');
		$father->shouldReceive('getBirthPlace')->andReturn($this->getPlaceMock('Miami, Florida, United States'));

		$family = Mockery::mock('Fisharebest\Webtrees\Family');
		$family->shouldReceive('getWife')->andReturn($father);

		$individual = Mockery::mock('Fisharebest\Webtrees\Individual');
		$individual->shouldReceive('getPrimaryChildFamily')->andReturn($family);

		$census = Mockery::mock('Fisharebest\Webtrees\Census\CensusInterface');
		$census->shouldReceive('censusPlace')->andReturn('United States');

		$column = new CensusColumnMotherBirthPlaceSimple($census, '', '');

		$this->assertSame('Florida', $column->generate($individual));
	}
}
