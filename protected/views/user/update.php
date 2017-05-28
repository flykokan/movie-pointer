<?php
/* @var $this UserController */
/* @var $model User */


$this->pageTitle=Yii::app()->name.' - Edit User '.$model->username;;
?>
<div class="box">
	<h1>
		Edit User
		<?php echo $model->username; ?>
	</h1>

	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>false,
	)); ?>
		<div class="row">
			<?php echo $form->labelEx($model,'role_id'); ?>
			<?php echo $form->dropDownList($model,'role_id',array(2=>'User',1=>'Admin')); ?>
			<?php echo $form->error($model,'role_id'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'approved'); ?>
			<?php echo $form->dropDownList($model,'approved',array(1=>'Yes',0=>'No')); ?>
			<?php echo $form->error($model,'approved'); ?>
		</div>
		
		<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
		</div>

	<?php $this->endWidget(); ?>

</div>
</div>
