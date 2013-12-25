<?php
$params = require(__DIR__ . '/params.php');
return [
	'id' => 'taskmanager-console',
	'basePath' => dirname(__DIR__),
	'preload' => ['log'],
	'controllerPath' => dirname(__DIR__) . '/commands',
	'controllerNamespace' => 'app\commands',
	'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=127.0.0.1;dbname=test',
			'username' => 'blog',
			'password' => 'bl1lg1',
			'charset' => 'utf8',
		],
	],
	'params' => $params,
];
