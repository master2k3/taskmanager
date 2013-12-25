<?php
/**
 * @var yii\base\View $this
 * @var app\modules\users\models\User $model
 */

use yii\base\Formatter;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Menu;

use app\modules\users\models\User;

$this->title = 'Профиль пользователя';
$Formatter = new Formatter();
?>
<div class="row">
	<?php if (!Yii::$app->user->isGuest) { ?>
		<div class="span3">
			<?php echo Menu::widget(array(
				'options' => array('class' => 'nav nav-pills nav-justified'),
				'items' => array(
					array(
						'label' => 'Список пользователей',
						'url' => array('/users')
					),
				)
			)); ?>
		</div>
	<?php } ?>
	<div class="<?php echo Yii::$app->user->isGuest ? 'span12' : 'span9'; ?>">
<div class="page-header">
	<h1><?php echo Html::encode($this->title); ?></h1>
</div>
<p>Id: <?php echo $model['id']; ?></p>
<p>Логин: <?php echo $model['username']; ?></p>
<p>Имя: <?php echo $model['realname']; ?></p>
<p>Роль: <?php echo $model['role'] == User::ROLE_ADMIN ? 'Администратор' : 'Пользователь'; ?></p>
<p>Активность: <?php if ($model['status'] == User::STATUS_ACTIVE) { echo 'Вкл'; } elseif($model['status'] == User::STATUS_INACTIVE) { echo 'Выкл'; } else { echo 'Забанен'; } ?></p>
<p>Создан: <?php echo Html::encode($Formatter->asDate($model['create_time'], 'd.m.Y')); ?></p>
<p>Изменен: <?php echo Html::encode($Formatter->asDate($model['update_time'], 'd.m.Y')); ?></p>
<?php 
				echo Html::a(NULL, array('/users'), array('class'=>'icon icon-back'));
?>
</div>
</div>