<?php
/* @var $this AuthorController */
/* @var $model Author */

$this->breadcrumbs=array(
    'Authors'=>array('index'),
    $model->id,
);
$menu = array(
    array('label'=>'List Author', 'url'=>array('index'))
);
if (!$isGuest) {
    $menu = array_merge(
        $menu,
        array(
            array('label'=>'Create Author', 'url'=>array('create')),
            array('label'=>'Update Author', 'url'=>array('update', 'id'=>$model->id)),
            array(
                'label'=>'Delete Author',
                'url'=>'#',
                'linkOptions'=>array(
                    'submit'=>array('delete','id'=>$model->id,),
                    'confirm'=>'Are you sure you want to delete this item?',
                    'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)
                )
            ),
            array('label'=>'Manage Author', 'url'=>array('admin'))
        )
    );
}
$this->menu = $menu;
// $this->menu=array(
//     array('label'=>'List Author', 'url'=>array('index')),
//     array('label'=>'Create Author', 'url'=>array('create')),
//     array('label'=>'Update Author', 'url'=>array('update', 'id'=>$model->id)),
//     array(
//         'label'=>'Delete Author',
//         'url'=>'#',
//         'linkOptions'=>array(
//             'submit'=>array('delete','id'=>$model->id,),
//             'confirm'=>'Are you sure you want to delete this item?',
//             'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)
//         )
//     ),
//     array('label'=>'Manage Author', 'url'=>array('admin')),
// );
?>

<h1>View Author #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'first_name',
        'last_name',
        'patronymic',
    ),
)); ?>