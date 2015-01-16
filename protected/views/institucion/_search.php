<?php
/* @var $this InstitucionController */
/* @var $model Institucion */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'institucion_id'); ?>
		<?php echo $form->textField($model,'institucion_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_institucion_id'); ?>
		<?php echo $form->textField($model,'tipo_institucion_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'institucion_vertical_id'); ?>
		<?php echo $form->textField($model,'institucion_vertical_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->