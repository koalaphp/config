<?php
/**
 * Created by PhpStorm.
 * User: laiconglin
 * Date: 22/04/2018
 * Time: 00:01
 */

use Koala\Config\ConfigPool;

class ConfigTest extends PHPUnit_Framework_TestCase
{
	public function testConfig() {
		$appConfig = ConfigPool::getConfig("app");
		echo PHP_EOL . json_encode($appConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
		$appConfigItem = ConfigPool::getConfigItem("app", "level1.level2.level3.hello");
		echo PHP_EOL . json_encode($appConfigItem, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
		$this->assertTrue(true);
	}
}
