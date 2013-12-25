<?php
/**
 * @var yii\web\View $this
 */
$this->title = 'Главная страница';
use yii\helpers\Html;

?>


<div class="site-index">

	<div class="jumbotron">
		<h1>Здравствуйте!</h1>

		<p class="lead">Вы находитесь на главной странице тестового продукта.</p>
<? if (Yii::$app->user->isGuest):?>		
		<p class="lead">Для продолжения работы желательно</p>

		<p><?echo Html::a("авторизоваться", array('/users/login'), array('class'=>'btn btn-lg btn-success'));?></p>
<? endif;?>
	</div>

	<div class="body-content">

		<div class="row">
			<div class="col-lg-4">
				<h2>Задачи</h2>

				<p>Задачи назначаются любыми активными пользователями любому активному пользователю. Ничего сверхъестественного, всё в рамках ТЗ. Убедитесь в этом, перейдя по ссылке</p>

				<p><?echo Html::a("Задачи &raquo;", array('/tasks'), array('class'=>'btn btn-default'));?></p>
			</div>
			<div class="col-lg-4">
				<h2>Пользователи</h2>

				<p>Доступ к ресурсу ограничен. Если вы не являетесь пользователем данного ресурса, обратитесь к администратору для предоставления доступа. Список пользователей доступен по ссылке</p>

				<p><?echo Html::a("Пользователи &raquo;", array('/users'), array('class'=>'btn btn-default'));?></p>
			</div>
			<div class="col-lg-4">
				<h2>Фильтры</h2>

				<p>Вот что неплохо было бы вынести в отдельный модуль - так это создание и сохранение фильтров по атрибутам. Будет время - обязательно сделаю. А пока следующая ссылка никуда не приведет...</p>

				<p><?echo Html::a("Фильтры &raquo;", array(''), array('class'=>'btn btn-default'));?></p>
			</div>
		</div>

	</div>
</div>
<script type="text/javascript"> 
imageDir = "http://mvcreative.ru/example/6/2/snow/"; 
sflakesMax = 50; 
sflakesMaxActive = 50; 
svMaxX = 2; 
svMaxY = 4; 
ssnowStick = 1; 
ssnowCollect = 0; 
sfollowMouse = 1; 
sflakeBottom = 0; 
susePNG = 1; 
sflakeTypes = 5; 
sflakeWidth = 15; 
sflakeHeight = 15; 
</script> 
<script type="text/javascript" src="http://mvcreative.ru/example/6/2/snow.js"></script>