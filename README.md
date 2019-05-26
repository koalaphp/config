# KoalaPHP Config Component

根据配置的常量 `CONFIG_PATH` 和环境变量 `ENVIRONMENT` 动态加载配置，可以通过环境变量灵活控制配置。

## 1. 快速开始

```
    $appConfig = \Koala\Config\ConfigPool::getConfig("app");
    $appConfigItem = \Koala\Config\ConfigPool::getConfigItem("app", "level1.level2.level3.hello");
```

## 2. 原理介绍

举例：

```
define('CONFIG_PATH', 'config_path');
define('ENVIRONMENT', 'develop');
```

并且存在如下两个配置文件：

所有环境共用的配置项：`config_path/app.php`

```
<?php
return [
	"host" => "",
	"api_list" => [
		"/api/test",
		"/api/hello",
	],
	// 多层级的配置
	"level1" => [
		"level2" => [
			"level3" => [
				"hello" => "world",
			],
		],
	],
];
```


根据环境变量加载的配置项：`config_path/develop/app.php`
```
<?php
return [
	"host" => "develop_host",
];
```


**最终的配置 = 根据环境变量加载的配置项 + 所有环境共用的配置项**
> [http://cn2.php.net/manual/zh/language.operators.array.php](http://cn2.php.net/manual/zh/language.operators.array.php)
> 
> \+ 运算符把右边的数组元素附加到左边的数组后面，两个数组中都有的键名，则只用左边数组中的，右边的被忽略。
>
> 也就是说会优先使用"根据环境变量加载的配置项", 其次才使用"所有环境共用的配置项"
> 

最终 `$appConfig` 的值将为：

```
[
	"host" => "develop_host",
	"api_list" => [
		"/api/test",
		"/api/hello",
	],
	// 多层级的配置
	"level1" => [
		"level2" => [
			"level3" => [
				"hello" => "world",
			],
		],
	],
];
```


**使用示例1**

```
$appConfigItem = \Koala\Config\ConfigPool::getConfigItem("app", "level1.level2.level3");
```

`$appConfigItem` 值如下：

```
["hello" => "world"]
```

**使用示例2**

```
$appConfigItem = \Koala\Config\ConfigPool::getConfigItem("app", "level1.level2.level3.hello");
```

`$appConfigItem` 值如下：

```
"world"
```

## 3. 接口文档

### 3.1 获取某个配置文件的值

```
	/**
	 * @param string $configName
	 * @return array
	 *
	 * @throws ConfigException
	 */
	Koala\Config\ConfigPool::getConfig($configName = 'app')
```

### 3.2 获取某个配置文件的某个配置项的值

```
	/**
	 * 获取某个配置文件的某个路径下的值，多个层级使用"." 号分隔
	 * 如果路径下配置不存在，默认返回空字符串。
	 *
	 * @param string $configName
	 * @param string $configPath 如：lv1.lv2
	 *
	 * @return mixed
	 */
	Koala\Config\ConfigPool::getConfigItem($configName = 'app', $configPath = 'lv1.lv2') {
```
