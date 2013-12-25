<?php
/**
 * @var yii\base\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\LoginForm $model
 */
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Новый пользователь';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo Html::encode($this->title); ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
	<div class="alert alert-success">
		Пользователь успешно создан!
	</div>
<?php 
				echo Html::a(NULL, array('/users'), array('class'=>'icon icon-back'));
?>	
<?php return; endif; ?>

<p>Заполните сведения о новом пользователе:</p>

<?php echo $this->render('_form', array('model' => $model)) ?>
