<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'book-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <?php 
    ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'authors'); ?>
        <?php
        echo $form->dropDownList(
            $model,
            'authorIds',
            CHtml::listData(
                Author::model()->findAll(),
                'id',
                fn($item) => $item['first_name'] . ' ' . $item['last_name'] . ' ' . $item['patronymic'],                
            ),
            [
                'multiple' => true,
                'size' => 5,
                'required' => true,                
                'options' => array_fill_keys(
                    array_map(fn($item) => $item['id'], $model->authors),
                    ['selected' => true]
                ) // и сюда бы пайпы

                // 'prompt' => 'Укажите автора'
            ] // 'empty' => '--' 'class' => ''
        );
        ?>
        <?php echo $form->error($model, 'authors'); ?>

    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'release_year'); ?>
        <?php echo $form->textField($model,'release_year',array('size'=>4, 'maxlength'=>4, 'placeholder' => 'YYYY')); ?>
        <?php echo $form->error($model,'release_year'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'summary'); ?>
        <?php echo $form->textField($model,'summary',array('size'=>60,'maxlength'=>2024)); ?>
        <?php echo $form->error($model,'summary'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'isbn'); ?>
        <?php echo $form->textField($model,'isbn',array('size'=>17,'maxlength'=>17)); ?>
        <?php echo $form->error($model,'isbn'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'photo'); ?>
        <?php echo $form->textField($model,'photo',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'photo'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->