<?php
/**
 * Class Task
 * @package app\modules\tasks\models
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $expiration_time
 * @property integer $create_time
 * @property integer $update_time
 */

namespace app\modules\tasks\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;

class Task extends ActiveRecord
{
// 	const STATUS_DRAFT = 0;
// 	const STATUS_PUBLISHED = 1;
	
	const STATUS_NEW = 0;
	const STATUS_PROCESSING = 1;
	const STATUS_DONE = 2;
	const STATUS_CLOSED = 3;
	
// 	public STATUS_NAME[self::STATUS_NEW] = 'Новый';
// 	public STATUS_NAME[self::STATUS_PROCESSING] = 'В работе';
// 	public STATUS_NAME[self::STATUS_DONE] = 'Исполнен';
// 	public STATUS_NAME[self::STATUS_CLOSED] = 'Закрыт';

	public function behaviors()
	{
		return array(
			'timestamp' => array(
				'class' => 'yii\behaviors\AutoTimestamp',
				'attributes' => array(
					ActiveRecord::EVENT_BEFORE_INSERT => array('create_time', 'update_time'),
					ActiveRecord::EVENT_BEFORE_UPDATE => array('update_time'),
				),
			),
		);
	}

	public function attributeLabels()
	{
		return array(
			'title' => 'Тема задачи',
			'expiration_time' => 'Дата выполнения',
			'user_id' => 'Исполнитель',
			'content' => 'Описание',
			'status' => 'Статус',
		);
	}	
	
	public function getId()
	{
		return $this->id;
	}

	public static function getStatusName($status)
	{
		switch ($status)
		{
			case self::STATUS_NEW : return 'Новый'; break;
			case self::STATUS_PROCESSING : return 'В работе'; break;
			case self::STATUS_DONE : return 'Исполнен'; break;
			case self::STATUS_CLOSED : return 'Закрыт'; break;
			default: return '';
		}
	}

	public function rules()
	{
		return array(
			array('title', 'required'),
			array('title', 'string', 'max' => 255),

			array('content', 'required'),
			array('expiration_time', 'required'),
			array('user_id', 'required'),
			array('status', 'required'),
		);
	}

	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {
			if($this->isNewRecord) {
				$this->author_id = Yii::$app->user->identity->id;
			}
			
			
			$Purifier = new HtmlPurifier();
			$this->content = $Purifier->process($this->content);
			$this->expiration_time = strtotime($this->expiration_time);
			return true;
		}
		return false;
	}

}
