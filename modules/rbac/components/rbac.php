<?php 
use yii\rbac\Item;
use app\modules\users\models\User;

return array(
    'guest' => array(
        'type' => Item::TYPE_ROLE,
        'description' => 'Guest',
		'bizRule' => NULL,
        'data' => NULL
    ),
    User::ROLE_USER => array(
        'type' => Item::TYPE_ROLE,
        'description' => 'User',
        'children' => array(
            'guest',
            'editTask',
            'editOwnProfile',
            'editOwnComment',
            'deleteOwnComment'
        ),
        'bizRule' => 'return !Yii::$app->user->isGuest;',
        'data' => NULL
    ),
    User::ROLE_ADMIN => array(
        'type' => Item::TYPE_ROLE,
        'description' => 'Admin',
        'children' => array(
            User::ROLE_USER,
            'editProfile',
            'editTask',
            'editComment',
            'deleteProfile',
            'deleteTask',
            'deleteComment',
        ),
        'bizRule' => NULL,
        'data' => NULL
    ),
    'editOwnProfile' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Edit own profile',
        'bizRule' => 'return Yii::$app->user->identity->id == $params["user"]["id"];',
        'data' => NULL
    ),
    'editProfile' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Edit profile',
        'bizRule' => NULL,
        'data' => NULL
    ),
    'deleteOwnProfile' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete own profile',
        'bizRule' => 'return Yii::$app->user->identity->id == $params["user"]["id"];',
        'data' => NULL
    ),
    'deleteProfile' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete profile',
        'bizRule' => NULL,
        'data' => NULL
    ),
    'editOwnTask' => array(
		'type' => Item::TYPE_TASK,
		'description' => 'Edit own task',
		'bizRule' => 'return Yii::$app->user->identity->id == $params["task"]["author_id"];',
		'data' => NULL
	),
	'editTask' => array(
		'type' => Item::TYPE_TASK,
		'description' => 'Edit task',
		'bizRule' => NULL,
		'data' => NULL
	),
    'deleteOwnTask' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete own task',
        'bizRule' => 'return Yii::$app->user->identity->id == $params["task"]["author_id"];',
        'data' => NULL
    ),
    'deleteTask' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete task',
        'bizRule' => NULL,
        'data' => NULL
    ),
    'editOwnComment' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Edit own comment',
        'bizRule' => 'return Yii::$app->user->identity->id == $params["comment"]["author_id"];',
        'data' => NULL
    ),
    'editComment' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Edit comment',
        'bizRule' => NULL,
        'data' => NULL
    ),
    'deleteOwnComment' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete own comment',
        'bizRule' => 'return Yii::$app->user->identity->id == $params["comment"]["author_id"];',
        'data' => NULL
    ),
    'deleteComment' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete comment',
        'bizRule' => NULL,
        'data' => NULL
    )
);