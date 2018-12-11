<?php

namespace SoftCache;

/**
 * Class SoftCacheTrait
 * Cache method output in a class property
 * The cache is not persistent
 */
trait SoftCacheTrait {

	protected $cache = [];

	/**
	 * @param string $method Method name
	 * @param array $args
	 * @param $output mixed
	 */
	public function writeMethodCache($method, array $args, $output) {
		try {
			$cache_key = $this->getCacheKey($args);
			$this->cache[$method][$cache_key] = $output;
		} catch (\Exception $e) {

		}
	}

	/**
	 * @param string $method Method name
	 * @param array $args
	 * @return mixed
	 */
	public function readMethodCache($method, array $args) {
		try {
			$cache_key = $this->getCacheKey($args);
			if ($this->checkMethodCache($method, $args)) {
				return $this->cache[$method][$cache_key];
			}
		} catch (\Exception $e) {
			return false;
		}

		return false;
	}

	/**
	 * @param string $method Method name
	 * @param array $args
	 * @return bool
	 */
	public function checkMethodCache($method, array $args) {
		try {
			$cache_key = $this->getCacheKey($args);
			if (!array_key_exists($method, $this->cache)) {
				return false;
			}
			if (!array_key_exists($cache_key, $this->cache[$method])) {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}
		return true;
	}

	/**
	 * Generate an unique key
	 * @param array $args
	 * @return string
	 */
	public function getCacheKey(array $args) {
		return md5(serialize($args));
	}
}
