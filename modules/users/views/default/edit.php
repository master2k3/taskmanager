<?php
/**
 * @var yii\base\View $this
 * @var app\modules\users\models\User $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование пользователя';
?>
<div class="page-header">
	<h1><?php echo Html::encode($this->title); ?></h1>
</div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
	<div class="alert alert-success">
		Данные пользователя успешно изменены!
	</div>
<?php 
				echo Html::a(NULL, array('/users'), array('class'=>'icon icon-back'));
?>
<?php return; endif; ?>

<?php echo $this->render('_form', array('model' => $model)); ?>