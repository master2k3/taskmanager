<?php
/**
 * @var yii\base\View $this
 * @var app\modules\users\models\User $models
 * @var yii\data\Pagination $pages
 */

use yii\base\Formatter;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Menu;

use app\modules\users\models\User;

$this->title = 'Пользователи';
$Formatter = new Formatter();
?>
<div class="row">
	<?php if (!Yii::$app->user->isGuest) { ?>
		<div class="span3">
			<?php echo Menu::widget(array(
				'options' => array('class' => 'nav nav-pills nav-justified'),
				'items' => array(
					array(
						'label' => 'Создать пользователя',
						'url' => array('/users/create'),
						'visible' => (Yii::$app->user->checkAccess('editProfile'))
					),
				)
			)); ?>
		</div>
	<?php } ?>
	<div class="<?php echo Yii::$app->user->isGuest ? 'span12' : 'span9'; ?>">
<div class="page-header">
	<h1><?php echo Html::encode($this->title); ?></h1>
</div>

<table class="table table-striped table-hover">
	<tr>
		<td>#</td>
		<td>Логин</td>
		<td>Имя</td>
		<td>Роль</td>
		<td>Активность</td>
		<td>Создан</td>
		<td>Изменен</td>
		<td>Функции</td>
	</tr>
	<?php foreach ($models as $model): ?>
	<tr>
		<td><?php echo Html::encode($model['id']); ?></td>
		<td><?php 
		echo Html::a(Html::encode($model['username']), array('view', 'username' => $model['username'])); 
		?></td>
		<td><?php echo Html::encode($model['realname']); ?></td>
		<td><?php echo $model['role'] == User::ROLE_ADMIN ? 'Администратор' : 'Пользователь'; ?></td>
		<td><?php if ($model['status'] == User::STATUS_ACTIVE) { echo 'Вкл'; } elseif($model['status'] == User::STATUS_INACTIVE) { echo 'Выкл'; } else { echo 'Забанен'; } ?></td>
		<td><?php echo Html::encode($Formatter->asDate($model['create_time'], 'd.m.Y')); ?></td>
		<td><?php echo Html::encode($Formatter->asDate($model['update_time'], 'd.m.Y')); ?></td>
		<td>
			<?php if (Yii::$app->user->checkAccess('editOwnProfile', array('user' => $model)) || Yii::$app->user->checkAccess('editProfile')) {
				echo Html::a(NULL, array('edit', 'username' => $model['username']), array('class'=>'icon icon-edit'));
			}
			if (Yii::$app->user->checkAccess(User::ROLE_ADMIN) && $model['role'] != User::ROLE_ADMIN && $model['status'] != User::STATUS_DELETED) {
				echo Html::a(NULL, array('delete', 'username' => $model['username']), array('class'=>'icon icon-trash'));
			} ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<?php echo LinkPager::widget(array('pagination' => $pages)); ?>
</div>
</div>