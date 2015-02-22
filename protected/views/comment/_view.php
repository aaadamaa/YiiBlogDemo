<?php
/* @var $this CommentController */
/* @var $data Comment */
?>

<div class="view">

	<?php if($data->status == Comment::STATUS_PENDING) : ?>
		<span style="color:red;">Pending approval</span>
		<br />
		<?php echo CHtml::linkButton('Approve', array('submit'=>array(
			'comment/approve', 'id'=>$data->id
		))); ?>
		<br />
	<?php endif; ?>

	<?php echo CHtml::linkButton('Delete', array('submit'=>array(
		'comment/delete', 'id'=>$data->id
	))); ?>

	<br />
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link('#'.$data->id, $data->url, array(
		'title'=>'Permalink to this comment',
	)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('author')); ?>:</b>
	<?php echo CHtml::encode($data->author); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('post_id')); ?>:</b>
	<?php echo CHtml::encode($data->post_id); ?>
	<br />

	*/ ?>

</div>