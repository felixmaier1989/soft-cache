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
		$cache_key = $this->getCacheKey($args);
		$this->cache[$method][$cache_key] = $output;
	}

	/**
	 * @param string $method Method name
	 * @param array $args
	 * @return mixed
	 */
	public function readMethodCache($method, array $args) {
		$cache_key = $this->getCacheKey($args);
		if ($this->checkMethodCache($method, $args)) {
			return $this->cache[$method][$cache_key];
		}
		return false;
	}

	/**
	 * @param string $method Method name
	 * @param array $args
	 * @return bool
	 */
	public function checkMethodCache($method, array $args) {
		$cache_key = $this->getCacheKey($args);
		if (!array_key_exists($method, $this->cache)) {
			return false;
		}
		if (!array_key_exists($cache_key, $this->cache[$method])) {
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
