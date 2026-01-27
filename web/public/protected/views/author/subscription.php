<?php
/* @var $this AuthorController */
/* @var $model SubscriptionForm */
/* @var $authorId integer */

$this->pageTitle=Yii::app()->name . ' - Subscription';
$this->breadcrumbs=array(
	'Subscription',
);
?>

<h1>Author Subscription</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', [
    'id' => 'subscription-form',
    'enableClientValidation' => true,
    'clientOptions' => [
		'validateOnSubmit' => true,
    ],
    'enableAjaxValidation' => false,
]); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>    

    <div class="row">
        <?php echo $form->labelEx($model, 'phone'); ?>
        <?php echo $form->textField($model, 'phone', ['size' => 20, 'maxlength' => 20]); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model,'name', ['size'=>60, 'maxlength'=>128]); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <?php echo CHtml::hiddenField('author_id', $authorId); ?>

    <?php echo $form->hiddenField($model, 'author_id', ['value' => $authorId]); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Subscribe'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
