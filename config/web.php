<?php

$params = require(__DIR__ . '/params.php');

$config = [
	'id' => 'taskmanager',
	'basePath' => dirname(__DIR__),
	'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
	'defaultRoute' => 'site/default/index',
	'layoutPath' => '@app/modules/site/views/layouts',
	'viewPath' => '@app/modules/site/views',
	'modules' => array(
		'site' => array(
			'class' => 'app\modules\site\Site'
		),
		'users' => array(
			'class' => 'app\modules\users\Users'
		),
		'tasks' => array(
			'class' => 'app\modules\tasks\Tasks'
		),
		'comments' => array(
			'class' => 'app\modules\comments\Comments'
		),
		'rbac' => array(
			'class' => 'app\modules\rbac\Rbac'
		)
	),

	'components' => [
		'urlManager'=>array(
			'enablePrettyUrl' => true,
			'enableStrictParsing' => false,
			'showScriptName' => false,
			'suffix' => '/',
			'rules' => array(
				'/'=>'site/default/index',
				'<module:\w+>/<action:\w+>/<id:\d+>' => '<module>/default/<action>',
				'<module:\w+>' => '<module>/default/index',
				'<module:\w+>/<action:\w+>' => '<module>/default/<action>',
			)
		),
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			'class' => 'yii\web\User',
			'identityClass' => 'app\modules\users\models\User',
// 			'enableAutoLogin' => true,
		],
		'authManager' => array(
			'class' => 'app\modules\rbac\components\PhpManager',
			'defaultRoles' => array('guest'),
		),		
		'errorHandler' => [
			'errorAction' => 'site/default/error',
		],
		'mail' => [
			'class' => 'yii\swiftmailer\Mailer',
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => $params['components.db'],
	],
	'params' => $params,
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['preload'][] = 'debug';
	$config['modules']['debug'] = 'yii\debug\Module';
	$config['modules']['gii'] = 'yii\gii\Module';
}

if (YII_ENV_TEST) {
	// configuration adjustments for 'test' environment.
	// configuration for codeception test environments can be found in codeception folder.

	// if needed, customize $config here.
}

return $config;
