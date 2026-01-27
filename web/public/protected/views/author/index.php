<?php
/* @var $this AuthorController */
/* @var $dataProvider CActiveDataProvider */
/* @var $isGuest bool */

$this->breadcrumbs=array(
    'Authors',
);

$this->menu = $isGuest ? 
    array() : 
    array(
        array('label'=>'Create Author', 'url'=>array('create')),
        array('label'=>'Manage Author', 'url'=>array('admin')),
    );
?>

<h1>Authors</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'viewData' => ['isGuest' => $isGuest]
)); ?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', [
    'id' => 'author_books_dialog',
    'options'=> [
        'title' => 'Dialog box 1',
        'autoOpen' => false,
    ],
]);
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script>
    const $authorBooksDialog = $('#author_books_dialog');

    [...document.getElementsByClassName('dialog-author-books')].forEach(button => {
        button.addEventListener('click', ({ target }) => {
            const fullName = target.dataset.fullName;
            const books = JSON.parse(target.dataset.books);
            const bookList = books.map(book => 
                `<div style="padding: 12px 20px">
                    <b>Название:</b> ${book.title}<br>
                    <b>ISBN:</b> ${book.isbn}
                </div>`
            );
            
            $authorBooksDialog.html(bookList.join(''));            
            $authorBooksDialog.dialog( {
                height: 400,
                width: 600,
                title: fullName  + '. Список книг',
            } ).dialog('open');            
            return false;
        })
    })
</script>