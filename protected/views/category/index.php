<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);
?>

<h1>Categories</h1>

<?php echo CHtml::link('Create new category',array('category/create')); ?><br />
<?php echo CHtml::link('Update or Delete category',array('category/admin')); ?><br />