<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\comments\models\Comment $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<h3>Ваш комментарий</h3>

<?php 
$action = $model->isNewRecord ? array('/comments/default/create', 'returnUrl' => Yii::$app->request->url) : '';
$form = ActiveForm::begin(array(
	'action' => $action,
	'fieldConfig' => array(
		'template' => '<div class="controls">{input}{error}</div>'
	),
	'options' => array(
		'class' => 'form-vertical'
	)
));
echo $form->field($model, 'content')->textArea(array('rows' => 5, 'class' => 'form-control'));
if ($model->isNewRecord) {
	//echo $form->field($model, 'model_id', array('template' => '{input}'))->hiddenInput();
	echo Html::activeHiddenInput($model, 'model_id');
}
?>

<div class="form-actions">
	<?php echo Html::submitButton('Сохранить', array('class' => 'btn btn-primary')); ?>
</div>

<?php ActiveForm::end(); ?>