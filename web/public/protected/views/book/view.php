<?php
/* @var $this BookController */
/* @var $model Book */

$this->breadcrumbs=array(
    'Books'=>array('index'),
    $model->title,
);
$menu = array(
    array('label'=>'List Book', 'url'=>array('index'))
);
if (!$isGuest) {
    $menu = array_merge(
        $menu,
        array(
            array('label'=>'Create Book', 'url'=>array('create')),
            array('label'=>'Update Book', 'url'=>array('update', 'id'=>$model->id)),
            array(
                'label'=>'Delete Book',
                'url'=>'#',
                'linkOptions'=>array(
                    'submit'=>array('delete','id'=>$model->id),
                    'confirm'=>'Are you sure you want to delete this item?',
                    'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)
                )
            ),
            array('label'=>'Manage Book', 'url'=>array('admin')),
        )
    );
}
$this->menu = $menu;
?>

<h1>View Book #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        [
            'label' => 'Авторы',
            'type' => 'raw',
            'value' => join(', ', array_map(
                fn($item) => $item['first_name'] . ' ' . $item['last_name'] . ' ' . $item['patronymic'],
                $model->authors
            )), // сюда бы пайпы, но PHP 8.5 не поддерживает Yii 1
        ],
        'title',
        'release_year',
        'summary',
        'isbn',
        [
            'label' => 'Фото главной страницы',
            'type' => 'raw',
            'value' => CHtml::image($model->photo ?: $noPhoto, $model->title, [
                'style' => $model->photo ? 'width: 480px; min-width: 160px' : ''
            ]),
        ],
        // 'created_at',
        // 'updated_at',
    ),
)); ?>