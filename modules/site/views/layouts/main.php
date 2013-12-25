<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>"/>
	<title>Simple TaskManager - <?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<?php
		NavBar::begin([
			'brandLabel' => 'Simple TaskManager',
			'brandUrl' => Yii::$app->homeUrl,
			'options' => [
				'class' => 'navbar-inverse navbar-fixed-top',
			],
		]);
		echo Nav::widget([
			'options' => ['class' => 'navbar-nav navbar-right'],
			'items' => [
				['label' => 'Задачи', 'url' => ['/tasks'], 'visible' => !Yii::$app->user->isGuest],
				['label' => 'Пользователи', 'url' => ['/users'], 'visible' => !Yii::$app->user->isGuest],
				['label' => 'Вход', 'url' => ['/users/login'], 'visible' => Yii::$app->user->isGuest],
				['label' => 'Выход (' . (Yii::$app->user->isGuest ? '' : ((trim(Yii::$app->user->identity->realname)=='') ? Yii::$app->user->identity->username : Yii::$app->user->identity->realname)) . ')' ,
						'url' => ['/users/logout'],
						'linkOptions' => ['data-method' => 'post'],
						'visible' => !Yii::$app->user->isGuest
				],
			],
		]);
		NavBar::end();
	?>

	<div class="container">
		<?= Breadcrumbs::widget([
			'homeLink' => ['label' => 'Главная', 'url' => ['/site/index'],],
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>
		<?= $content ?>
	</div>

	<footer class="footer">
		<div class="container">
			<p class="pull-left">&copy; Master2k3 <?= date('Y') ?></p>
			<p class="pull-right"><?= Yii::powered() ?></p>
		</div>
	</footer>

<?php $this->endBody() ?>



</body>
</html>
<?php $this->endPage() ?>
