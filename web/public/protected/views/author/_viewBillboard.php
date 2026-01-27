<?php
/* @var $this AuthorController */
/* @var $data Array */
?>

<div class="view">

    <b>ID:</b>
    <?php echo CHtml::link(CHtml::encode($data['id']), array('view', 'id'=>$data['id'])); ?>
    <br />

    <b>Имя:</b>
    <?php echo CHtml::encode($data['first_name']); ?>
    <br />

    <b>Фамилия:</b>
    <?php echo CHtml::encode($data['last_name']); ?>
    <br />

    <b>Отчество:</b>
    <?php echo CHtml::encode($data['patronymic']); ?>
    <br />

    <b>Количество книг:</b>
    <?php echo CHtml::encode($data['booksCount']); ?>
    <br />
</div>