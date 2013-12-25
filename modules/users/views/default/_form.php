<?php
/**
 * @var yii\base\View $this
 * @var app\modules\users\models\User $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\users\models\User;

$form = ActiveForm::begin(array('options' => array('class' => 'form-horizontal')));
echo $form->field($model, 'username')->textInput($model->isNewRecord ? array() : array('readonly' => true));
echo $form->field($model, 'realname')->textInput();
echo $form->field($model, 'email')->textInput();
if (!$model->isNewRecord) {
    if (Yii::$app->user->checkAccess('editProfile')) {
        echo $form->field($model, 'status')->dropDownList(array(
        	User::STATUS_ACTIVE => 'Вкл',
        	User::STATUS_INACTIVE => 'Выкл',
        	User::STATUS_DELETED => 'Забанен'
        ));
        echo $form->field($model, 'role')->dropDownList(array(
        	User::ROLE_USER => 'Пользователь',
        	User::ROLE_ADMIN => 'Администратор'
        ));
    }
// 	echo $form->field($model, 'oldpassword')->passwordInput();
}
echo $form->field($model, 'password')->passwordInput();
echo $form->field($model, 'repassword')->passwordInput();
?>

<div class="form-actions">
	<?php echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class' => 'btn btn-primary')); ?>
</div>

<?php ActiveForm::end(); ?>
