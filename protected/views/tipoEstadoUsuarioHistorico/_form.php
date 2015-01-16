<?php
/* @var $this TipoEstadoUsuarioHistoricoController */
/* @var $model TipoEstadoUsuarioHistorico */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tipo-estado-usuario-historico-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_creacion'); ?>
		<?php echo $form->textField($model,'fecha_creacion'); ?>
		<?php echo $form->error($model,'fecha_creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo_usuario_id'); ?>
		<?php echo $form->textField($model,'tipo_usuario_id'); ?>
		<?php echo $form->error($model,'tipo_usuario_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uduario_id'); ?>
		<?php echo $form->textField($model,'uduario_id'); ?>
		<?php echo $form->error($model,'uduario_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->