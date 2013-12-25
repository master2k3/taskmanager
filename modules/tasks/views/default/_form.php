<?php
/**
 * @var yii\base\View $this
 * @var app\modules\tasks\models\Task $model
 */
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$form = ActiveForm::begin(array('options' => array('class' => 'form-vertical')));
echo $form->field($model, 'title')->textInput(array('class' => 'form-control'));
echo $form->field($model, 'expiration_time')->widget(DatePicker::className(),['language' => 'ru','clientOptions' => ['dateFormat' => 'dd.mm.yy']]);

$selectValues = \yii\helpers\ArrayHelper::map($users, 'id', 'realname');

echo $form->field($model, 'user_id')->dropDownList($selectValues);

echo $form->field($model, 'status')->dropDownList($status);

echo $form->field($model, 'content')->textArea(array('class' => 'form-control', 'rows' => 10));
?>

<div class="form-actions">
	<?php echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class' => 'btn btn-primary')); ?>
</div>

<?php ActiveForm::end(); ?>
