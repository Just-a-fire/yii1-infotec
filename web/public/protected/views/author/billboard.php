<?php
/* @var $this AuthorController */
/* @var $dataProvider CArrayDataProvider */

$this->breadcrumbs = [
    'Authors' => ['index'],
    'Top'
];
?>
<h1>Authors of <?= $year ?></h1>

<?php $this->widget('zii.widgets.CListView', [
    'dataProvider' => $dataProvider,
    'itemView' => '_viewBillboard',
    'viewData' => ['year' => $year]
]); ?>