<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\comments\models\Comment $models
 * @var app\modules\comments\models\Comment $model
 */

use yii\base\Formatter;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<hr />
<?php 
if (count($models)) {
	$Formatter = new Formatter();
?>
    <h3>Комментарии</h3>
    <?php foreach ($models as $key => $comment) { ?>
        <blockquote>
        	<small><?php echo $Formatter->asDate($comment['create_time'], 'H:i:s d.m.Y');?> <b><?=$comment->author['realname'];?></b></small>
        	<p><?php echo $comment['content']; ?></p>
        	<?php if (Yii::$app->user->checkAccess('editOwnComment', array('comment' => $comment)) || Yii::$app->user->checkAccess('editComment')) {
                echo '<small><em>'.Html::a('Править', array('/comments/default/edit', 'id' => $comment['id'], 'returnUrl' => Yii::$app->request->url)) . '</em></small>';
            }
            if (Yii::$app->user->checkAccess('deleteOwnComment', array('comment' => $comment)) || Yii::$app->user->checkAccess('deleteComment')) {
                echo '<small><em>'.Html::a('Удалить', array('/comments/default/delete', 'id' => $comment['id'], 'returnUrl' => Yii::$app->request->url)) . '</em></small>'; 
            } ?>
        </blockquote>
    <?php }
}
if (!Yii::$app->user->isGuest)
    echo $this->render('_form', array('model' => $model)); 
?>