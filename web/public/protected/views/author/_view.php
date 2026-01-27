<?php
/* @var $this AuthorController */
/* @var $data Author */
/* @var $isGuest bool */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
    <?php echo CHtml::encode($data->first_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
    <?php echo CHtml::encode($data->last_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('patronymic')); ?>:</b>
    <?php echo CHtml::encode($data->patronymic); ?>
    <br />

    <b>Количество книг:</b>
    <?php 
    $fields = ['id', 'title', 'release_year', 'summary', 'isbn', 'photo'];
    $bookData = [];
    foreach ($data->books as $book) {
        $bookData[] = array_reduce(
            $fields,
            fn($carry, $field) => array_merge($carry, [$field => $book[$field]]),
            []
        );
    }
    $fullName = join(' ', [$data->first_name, $data->last_name, $data->patronymic]);

    $booksCountContent = '0';
    if (count($bookData)) {
        $booksCountContent = CHtml::htmlButton(count($data->books), [
            'class' => 'dialog-author-books',
            'data-full-name' => $fullName,
            'data-books' => json_encode($bookData, JSON_UNESCAPED_UNICODE)
        ]);
    }    
    echo $booksCountContent;
    ?>
    <br />

    <?php if($isGuest): ?>
    <?php echo CHtml::link('Подписаться', ['subscription', 'id' => $data->id]); ?>
    <br />
    <?php endif; ?>
</div>