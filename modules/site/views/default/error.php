<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

// $this->title = $name;
$this->title = "Страница не найдена";
?>
<div class="site-error">

	<h1><?= Html::encode($this->title) ?></h1>

	<div class="alert alert-danger">
		<?= nl2br(Html::encode($message)) ?>
	</div>

	<p>
		Что-то пошло не так, бла-бла-бла...
	</p>
	<p>
		Воспользуйтесь меню, или покиньте ресурс.
	</p>

</div>
