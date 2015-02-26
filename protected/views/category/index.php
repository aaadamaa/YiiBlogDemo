<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);
?>

<h1>Categories</h1>

<?php echo CHtml::link('Create Category',array('category/create')); ?><br />
<?php echo CHtml::link('Update Category',array('category/update')); ?><br />
<?php echo CHtml::link('Delete Category',array('category/delete')); ?><br />