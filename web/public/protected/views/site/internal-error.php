<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Ошибка';
$this->breadcrumbs=array(
	'Ошибка',
);
?>

<h2>Внутренняя ошибка</h2>
<?php echo CHtml::image('https://master-plus23.ru/www/images/9d7e441c2c5e1cdba5c7f4de8229667b-1.jpeg', 'Починка компьютера', ['width' => '100%', 'opacity' => '0.8']); ?>  
<div class="error">
    На сайте возникла ошибка, но мы уже её исправляем
</div>