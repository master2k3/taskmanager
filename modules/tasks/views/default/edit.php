<?php
/**
 * @var yii\base\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\tasks\Task $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
	<h1><?php echo Html::encode($this->title); ?></h1>
</div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
	<div class="alert alert-success">
		Задача обновлена!
	</div>
<?php return; endif; ?>

<?php echo $this->render('_form', array('model' => $model, 'users' => $users, 'status' => $status)) ?>