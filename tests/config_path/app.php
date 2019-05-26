<?php
/**
 * Created by PhpStorm.
 * User: laiconglin
 * Date: 2018/9/24
 * Time: 16:05
 */

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
