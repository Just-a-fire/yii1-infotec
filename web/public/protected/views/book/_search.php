
<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'id'); ?>
        <?php echo $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>256)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'release_year'); ?>
        <?php echo $form->textField($model,'release_year',array('size'=>4,'maxlength'=>4)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'summary'); ?>
        <?php echo $form->textField($model,'summary',array('size'=>60,'maxlength'=>2024)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'isbn'); ?>
        <?php echo $form->textField($model,'isbn',array('size'=>17,'maxlength'=>17)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'photo'); ?>
        <?php echo $form->textField($model,'photo',array('size'=>60,'maxlength'=>255)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->