<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<?php
$maxLevel = Category::getMaxLevel();
$categorySelectJS = "function(data){
	data = JSON.parse(data);

	var maxLevel = '$maxLevel';
	var level = parseInt(data.level);

	if(level + 1 > maxLevel){
		return;
	}

	var elementId = '#subcategory_' + level;
	var divId = '#subcategoryDiv_' + level;

	if(data.html != ''){
		$(elementId).html(data.html);
		$(divId).show();
	}

	for(var i = level + 1; i < maxLevel; i++){
		elementId = '#subcategory_' + i;
		divId = '#subcategoryDiv_' + i;
		$(divId).hide();
		$(elementId).html('');
	}


}"
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textField($model,'tags',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'category'); ?>
		<?php echo $form->dropDownList($model, 'category', Category::getMainCategories(), array(
			'ajax'=>array(
				'type'=>'POST',
				'url'=>Yii::app()->createUrl('category/loadSubcategories'),
				'success'=>$categorySelectJS,
				'data'=>array('parent'=>'js:this.value'),
			),
		)); ?>
		<?php echo $form->error($model, 'category'); ?>
	</div>

	<?php for($i=0; $i<$maxLevel; $i++): ?>
	<div class="row" id="subcategoryDiv_<?= $i ?>" style='display:none;'>
		<?php echo $form->dropDownList($model, 'category', array(), array(
			'id'=>"subcategory_$i",
			'ajax'=>array(
				'type'=>'POST',
				'url'=>Yii::app()->createUrl('category/loadSubcategories'),
				'success'=>$categorySelectJS,
				'data'=>array('parent'=>'js:this.value'),
		))); ?>
		<?php echo $form->error($model, 'category'); ?>
	</div>
	<?php endfor; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', Lookup::items('PostStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->