<?php
/**
 * @var yii\base\View $this
 * @var app\modules\tasks\models\Task $models
 * @var yii\data\Pagination $pages
 */

use yii\base\Formatter;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\LinkPager;
use yii\jui\DatePicker;

use app\modules\tasks\models\Task;
use app\modules\users\models\User;

$this->title = 'Список задач';
$Formatter = new Formatter();
?>
<div class="row">
	<?php if (!Yii::$app->user->isGuest) { ?>
		<div class="span3">
			<?php echo Menu::widget(array(
				'options' => array('class' => 'nav nav-pills nav-justified'),
				'items' => array(
					array('label' => 'Новая задача', 'url' => array('/tasks/default/create'))
				)
			)); ?>
		</div>
	<?php } ?>
	<div class="<?php echo Yii::$app->user->isGuest ? 'span12' : 'span9'; ?>">
		<div class="page-header">
			<h1><?php echo Html::encode($this->title); ?></h1>
		</div>
		<p></p>
		<p>
		<?echo Html::a(Html::encode('Все'), array('/tasks'),array('class' => 'btn btn-default '.((!isset($_GET['status'])) ? 'gray' : '')));?>
		<?php foreach ($status as $id=>$name) { ?>
	    	<?echo Html::a(Html::encode($name), array('', 'status' => $id),array('class' => 'btn btn-default '.((isset($_GET['status']) && $_GET['status']==$id) ? 'gray' : '')));?>
		<?php } ?>
&nbsp;&nbsp;&nbsp;Дата исполнения: <?echo DatePicker::widget(array( 'language' => 'ru', 'name' => 'date', 'clientOptions' => array( 'dateFormat' => 'dd.mm.yy', ), )); ?>
		</p>
<table class="table table-striped table-hover">
	<tr>
		<td>#</td>
		<td>Статус</td>
		<td>Тема</td>
		<td>Инициатор</td>
		<td>Исполнитель</td>
		<td>Дата постановки</td>
		<td>Дата исполнения</td>
		<td>Функции</td>
	</tr>
	<?php foreach ($models as $model): ?>
	<?
	// треш и угар...
	$author = User::findIdentity($model['author_id']);
	$model['author_id'] = $author -> realname;
	$user =  User::findIdentity($model['user_id']);
	$model['user_id'] = $user -> realname;
	// ... но куда деваться, если времени нет
	?>
	<tr>
		<td><?php echo Html::a(Html::encode($model['id']), array('view', 'id' => $model['id'])); ?></td>
		<td><?php echo Html::encode(Task::getStatusName($model['status'])); ?></td>
		<td><?php echo Html::a(Html::encode($model['title']), array('view', 'id' => $model['id']));?></td>
		<td><?php echo Html::encode($model['author_id']); ?></td>
		<td><?php echo Html::encode($model['user_id']); ?></td>
		<td><?php echo Html::encode($Formatter->asDate($model['create_time'], 'd.m.Y')); ?></td>
		<td><?php echo Html::encode($Formatter->asDate($model['expiration_time'], 'd.m.Y')); ?></td>
		<td>
			<?php if (Yii::$app->user->checkAccess('editOwnTask', array('task' => $model)) || Yii::$app->user->checkAccess('editTask')) {
				echo Html::a(NULL, array('edit', 'id' => $model['id']), array('class'=>'icon icon-edit'));
			}
			if (Yii::$app->user->checkAccess('deleteOwnTask', array('task' => $model)) || Yii::$app->user->checkAccess('deleteTask'))  {
				echo Html::a(NULL, array('delete', 'id' => $model['id']), array('class'=>'icon icon-trash'));
			} ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>		
		<?php echo LinkPager::widget(array('pagination' => $pages)); ?>
	</div>
</div>