<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Create',
);

$maxLevel = Category::getMaxLevel();

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form-create',
	'enableAjaxValidation'=>false,
)); ?>

<h1>Create Category</h1>

Parent Category:<br >
<?php echo Category::mainCategoryDropdown(); ?>
<br />
<?php for($i=0; $i<$maxLevel; $i++): ?>
	<div id="subcategoryDiv_<?= $i ?>">
		<?php echo Category::subcategoryDropdown("subcategory[$i]", "subcategory_$i"); ?>
	</div>
<?php endfor; ?>
<?php echo $form->labelEx($model,'name'); ?>
<?php echo CHtml::activeTextField($model, 'name'); ?>
<?php echo $form->error($model,'name'); ?>



<div class="row buttons">
	<?php echo CHtml::submitButton('Create'); ?>
</div>


<?php $this->endWidget(); ?>

</div><!-- form -->