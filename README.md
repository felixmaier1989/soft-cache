# soft-cache
Soft cache for your class methods. Sometimes, during one script run, one method is executed several times with the same arguments. Better caching the output of it, especially when querying a databse or an API.

## Usage

```php
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
```
