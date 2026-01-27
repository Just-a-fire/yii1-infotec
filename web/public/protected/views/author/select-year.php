<?php
/* @var $this AuthorController */
/* @var $model ContactForm */

$this->breadcrumbs=array(
    'Year selection',
);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', ['id'=> 'year-form']); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'year'); ?>
        <?php echo $form->textField($model, 'year', ['size'=> 4, 'maxlength'=> 4]); ?>
        <?php echo $form->error($model, 'year'); ?>
    </div>

    <div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->