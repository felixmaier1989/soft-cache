<?php

use SoftCache\SoftCacheTrait;

/**
 * Class SoftCacheTraitTest
 * @property TestClass $Class
 */
class SoftCacheTraitTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		parent::setUp();
		$this->Class = new TestClass();
	}

	public function test_methodWithoutCache() {
		$actual = $this->Class->getNextYearsWithoutCache(2016, 5);
		$this->assertEquals([2017, 2018, 2019, 2020, 2021], $actual);
	}

	public function test_methodWithCache() {
		$actual = $this->Class->getNextYearsWithCache(2016, 5);
		$this->assertEquals([2017, 2018, 2019, 2020, 2021], $actual);

		// @todo execute again and assert getNextYearsWithoutCache isnt called
	}

}

class TestClass {
	use SoftCache\SoftCacheTrait;

	public function getNextYearsWithCache($yearFrom, $years) {
		if ($this->checkMethodCache(__FUNCTION__, func_get_args())) {
			return $this->readMethodCache(__FUNCTION__, func_get_args());
		}
		$output = $this->getNextYearsWithoutCache($yearFrom, $years);
		$this->writeMethodCache(__FUNCTION__, func_get_args(), $output);
		return $output;
	}

	public function getNextYearsWithoutCache($yearFrom, $years) {
		return range($yearFrom + 1 , $yearFrom + $years);
	}

}
