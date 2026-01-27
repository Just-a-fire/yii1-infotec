<?php
/* @var $this BookController */
/* @var $data Book */
?>

<?php
$fields = ['first_name', 'patronymic', 'last_name'];
$relationData = [];
foreach ($data->authors as $authors) {
    $relationDatum = array_reduce(
        $fields,
        fn($carry, $field) => array_merge($carry, [$field => $authors[$field]]),
        []
    );
    $relationData[] = join(' ', $relationDatum);
}
?>

<div class="view">

    <?php echo CHtml::image($data->photo ?: $noPhoto, $data->title, [
        'style' => 'width: 160px; min-width: 160px',
        'class' => 'image'
    ]); ?>  
    
    <div class="text-content">
        <h3><?php echo join(', ', $relationData); ?></h3>

        <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
        <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
        <?php echo CHtml::encode($data->title); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('release_year')); ?>:</b>
        <?php echo CHtml::encode($data->release_year); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('summary')); ?>:</b>
        <?php echo CHtml::encode($data->summary); ?>
        <br />

        <b><?php echo CHtml::encode(mb_strtoupper($data->getAttributeLabel('isbn'))); ?>:</b>
        <?php echo CHtml::encode($data->isbn); ?>
        <br />
    </div> 

</div>

<style>
    .view {
        display: flex;
        align-items: center;
    }

    .image {
        max-width: 100%;
        height: auto;
        margin-right: 20px;
    }

    .text-content {
        flex-grow: 1;
    }
</style>

