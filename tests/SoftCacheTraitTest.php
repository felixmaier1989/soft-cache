<?php

/**
 * Class SoftCacheTraitTest
 * @property TestClass $Class
 */
class SoftCacheTraitTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		parent::setUp();
		$this->Class = new TestClass();
	}

	public function test_getCacheKey_size() {
		$array1 = [
			'name' => 'Alpha',
			'description' => '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
			'author_id' => 4,
			'Author' => [
				'name' => 'Beta',
				'description' => '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
			],
			'Retailer' =>[
				[
					'name' => 'Charlie',
					'description' => '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
					'Address' => [
						'firstname' => 'Delta',
						'lastname' => 'Echo',
						'street1' => 'Foxtrot',
						'street2' => '',
						'zip' => '12345',
						'city' => 'Golf',
						'country' => 'VN',
					],

				],
				[
					'name' => 'Hotel',
					'description' => '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
					'Address' => [
						'firstname' => 'Delta',
						'lastname' => 'Echo',
						'street1' => 'Foxtrot',
						'street2' => '',
						'zip' => '12345',
						'city' => 'Golf',
						'country' => 'VN',
					],

				],
				[
					'name' => 'India',
					'description' => '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
					'Address' => [
						'firstname' => 'Delta',
						'lastname' => 'Echo',
						'street1' => 'Foxtrot',
						'street2' => '',
						'zip' => '12345',
						'city' => 'Golf',
						'country' => 'VN',
					],
				],
			],
		];
		$array3 = $array2 = $array1;
		$array2['Retailer'][2]['Address']['zip'] .= '6';
		$array3['Retailer'][2]['description'] .= '<br/>';
		$cache_key1 = $this->Class->getCacheKey([$array1]);
		$cache_key2 = $this->Class->getCacheKey([$array2]);
		$cache_key3 = $this->Class->getCacheKey([$array3]);
		$this->assertNotEmpty($cache_key1);
		$this->assertNotEmpty($cache_key2);
		$this->assertNotEquals($cache_key1, $cache_key2);
		$this->assertNotEquals($cache_key1, $cache_key3);
		$this->assertLessThan(100, strlen($cache_key1));
		$this->assertLessThan(100, strlen($cache_key2));
		$this->assertLessThan(100, strlen($cache_key3));
	}

	public function test_getCacheKey() {
		$cache_key1 = $this->Class->getCacheKey([2015]);
		$cache_key2 = $this->Class->getCacheKey([2016]);
		$this->assertNotEmpty($cache_key1);
		$this->assertNotEmpty($cache_key2);
		$this->assertNotEquals($cache_key1, $cache_key2);
	}

	public function test_methodWithoutCache() {
		$actual = $this->Class->getNextYearsWithoutCache(2016, 5);
		$this->assertEquals([2017, 2018, 2019, 2020, 2021], $actual);
	}

	public function test_methodWithCacheThreeTimes() {

		$this->Class = $this->getMock('TestClass', ['getNextYearsWithoutCache']);

		$this->Class
			->expects($this->once())
			->method('getNextYearsWithoutCache')
			->will($this->returnValue([2017, 2018, 2019, 2020, 2021]));

		$actual = $this->Class->getNextYearsWithCache(2016, 5);
		$this->assertEquals([2017, 2018, 2019, 2020, 2021], $actual);

		$actual = $this->Class->getNextYearsWithCache(2016, 5);
		$this->assertEquals([2017, 2018, 2019, 2020, 2021], $actual);

		$actual = $this->Class->getNextYearsWithCache(2016, 5);
		$this->assertEquals([2017, 2018, 2019, 2020, 2021], $actual);
	}

	public function test_methodWithCache() {
		$actual = $this->Class->getNextYearsWithCache(2016, 5);
		$this->assertEquals([2017, 2018, 2019, 2020, 2021], $actual);
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
