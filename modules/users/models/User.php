<?php
/**
 * Class User
 * @package app\modules\users\models
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $realname
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */

namespace app\modules\users\models;

use Yii;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
// use yii\helpers\Security;
// use yii\web\Identity;
use yii\helpers\Security;
use yii\web\IdentityInterface;


class User extends ActiveRecord implements IdentityInterface
{
	/**
	 * @var string the raw password. Used to collect password input and isn't saved in database
	 */
	public $password;
	public $repassword;
	public $oldpassword;

	/**
	 * @var Module yii\base\Module of model
	 */
	protected $_module;
	protected $auth_key;

	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_DELETED = 2;

	const ROLE_USER = 0;
	const ROLE_ADMIN = 1;

	const EVENT_NEW_USER = 'newUser';

	public function behaviors()
	{
		return array(
			'timestamp' => array(
				'class' => 'yii\behaviors\AutoTimestamp',
				'attributes' => array(
					ActiveRecord::EVENT_BEFORE_INSERT => array('create_time', 'update_time'),
					ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
				),
			),
		);
	}

	public static function findIdentity($id)
	{
		return static::find($id);
	}

	public static function findByUsername($username)
	{
		return static::find(array('username' => $username));
	}

	public function getId()
	{
		return $this->id;
	}

	public function getModule()
	{
		if ($this->_module === NULL)
			$this->_module = Yii::$app->getModule('users');

		return $this->_module;
	}

	public function getAuthKey()
	{
		return $this->auth_key;
	}

	public function validateAuthKey($authKey)
	{
		return $this->auth_key === $authKey;
	}

	public function validatePassword($password)
	{
		return Security::validatePassword($password, $this->password_hash);
	}

	public function validateUpdatePassword()
	{
		if (!empty($this->password)) {
			if (empty($this->repassword))
				$this->addError('repassword', 'Поле подтверждения пароля не может быть пустым.');
// 			if (empty($this->oldpassword))
// 				$this->addError('oldpassword', 'Поле текущего пароля не может быть пустым.');
		}
	}

// 	public function validateOldPassword()
// 	{
// 		if (!$this->validatePassword($this->oldpassword))
// 			$this->addError('oldpassword', 'Текущий пароль не такой.');
// 	}

	public function rules()
	{
		return array(
			array('username', 'filter', 'filter' => 'trim'),
			array('username', 'required'),
			array('username', 'string', 'min' => 3, 'max' => 25),
			array('username', 'unique', 'message' => 'This username has already been taken.'),

			array('email', 'filter', 'filter' => 'trim'),
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'unique', 'message' => 'This email address has already been taken.'),

			array('password', 'required', 'on' => array('create', 'login')),
			array('password', 'string', 'min' => 3, 'max' => 30),
			array('password', 'validateUpdatePassword', 'on' => 'update'),

			array('repassword', 'required', 'on' => array('create')),
			array('repassword', 'string', 'min' => 3, 'max' => 30, 'on' => array('create', 'update')),
			array('repassword', 'compare', 'compareAttribute'=>'password', 'on' => array('create', 'update')),

		);
	}

	public function scenarios()
	{
		return array(
			'update' => array('email', 'realname', 'password', 'repassword', 'status', 'role'),
			'create' => array('username', 'realname', 'email', 'password', 'repassword'),
			'login' => array('username', 'password'),
			'default' => array(),
		);
	}

	public function attributeLabels()
	{
		return array(
// 			'repassword' => 'Подтверждение пароля',
// 			'oldpassword' => 'Текущий пароль',
		);
	}

	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {
			if ($this->isNewRecord) {
				if (!empty($this->password))
					$this->password_hash = Security::generatePasswordHash($this->password);
				if ($this->module->activeAfterRegistration)
					$this->status = self::STATUS_ACTIVE;
				$this->activkey = Security::generateRandomKey();
			} else {
				if ($this->scenario === 'activation')
					$this->activkey = Security::generateRandomKey();
// 				if ($this->scenario === 'update')
// 					$this->password_hash = Security::generatePasswordHash($this->password);
			}
			return true;
		}
		return false;
	}

	/**
	 * It's just an exemple of an own event. In realy app you can use [[self::EVENT_AFTER_INSERT]]
	 */
	public function afterSave($insert)
	{
		$event = new ModelEvent;
		$this->trigger(self::EVENT_NEW_USER, $event);

		parent::afterSave($insert);
	}

	/**
	 * Exemple of Yii2 scope.
	 * @param yii\db\Query
	 */
	public function active($query)
	{
		return $query->andWhere('status = ' . self::STATUS_ACTIVE);
	}
}
