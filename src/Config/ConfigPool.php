<?php/** * Created by PhpStorm. * User: laiconglin * Date: 01/01/2017 * Time: 22:04 */namespace Koala\Config;use Koala\Config\ErrorCode;class ConfigPool {	protected static $configMap = [];	/**	 * 获取某个配置文件的配置数组	 * @param string $configName	 * @return array	 *	 * @throws ConfigException	 */	public static function getConfig($configName = 'app')	{		if (!defined('CONFIG_PATH')) {			throw new ConfigException("undefined constant CONFIG_PATH", ErrorCode::INVALID_PARAM);		}		if (!is_string($configName) || empty(trim($configName))) {			throw new ConfigException("config name must be a not empty string", ErrorCode::INVALID_PARAM);		}		if (!isset(self::$configMap[$configName])) {			self::$configMap[$configName] = self::loadConfig($configName);		}		return self::$configMap[$configName];	}	/**	 * 获取某个配置文件的某个路径下的值，多个层级使用"." 号分隔	 * 如果路径下配置不存在，默认返回空字符串。	 *	 * @param string $configName	 * @param string $configPath 如：lv1.lv2	 *	 * @return mixed	 */	public static function getConfigItem($configName = 'app', $configPath = 'lv1.lv2') {		$val = "";		$curConfig = self::getConfig($configName);		if (empty($configPath)) {			return $val;		}		$configPath = explode(".", $configPath);		$pathSegCount = count($configPath);		$curIndex = 0;		do {			if (!empty($curConfig) && !empty($configPath[$curIndex]) && isset($curConfig[$configPath[$curIndex]])) {				$curConfig = $curConfig[$configPath[$curIndex]];			} else {				break;			}			// 已经获取到最后一层级之后，就可以跳出循环了			if ($curIndex == ($pathSegCount - 1)) {				$val = $curConfig;				break;			}			$curIndex++;		} while ($curIndex <= $pathSegCount);		return $val;	}	/**	 * @param $name	 * @return array	 * @throws ConfigException	 */	protected static function loadConfig($name)	{		if (!defined('CONFIG_PATH')) {			throw new ConfigException("undefined constant CONFIG_PATH", ErrorCode::INVALID_PARAM);		}		$loadByEnv = "";		if (defined('ENVIRONMENT')) {			$loadByEnvConfigFilePath = CONFIG_PATH . ENVIRONMENT . DIRECTORY_SEPARATOR . $name . '.php';			if (file_exists($loadByEnvConfigFilePath) && is_readable($loadByEnvConfigFilePath)) {				$loadByEnv = $loadByEnvConfigFilePath;			}		}		$curConfigFilePath = CONFIG_PATH . $name . '.php';		if (!file_exists($curConfigFilePath) || !is_readable($curConfigFilePath)) {			throw new ConfigException('config file not found : ' . $curConfigFilePath, ErrorCode::INVALID_PARAM);		}		$curConfig = require $curConfigFilePath;		if (!is_array($curConfig)) {			throw new ConfigException('config file [' . $curConfigFilePath . '], need return an array but a ' . gettype($curConfig) . ' given', ErrorCode::INVALID_PARAM);		}		if (!empty($loadByEnv)) {			$loadByEnvConfig = require $loadByEnv;			if (!is_array($loadByEnvConfig)) {				throw new ConfigException('ENVIRONMENT config file [' . $loadByEnv . '], need return an array but a ' . gettype($loadByEnvConfig) . ' given', ErrorCode::INVALID_PARAM);			}			// http://cn2.php.net/manual/zh/language.operators.array.php			// + 运算符把右边的数组元素附加到左边的数组后面，两个数组中都有的键名，则只用左边数组中的，右边的被忽略。			$curConfig = $loadByEnvConfig + $curConfig;		}		return $curConfig;	}}