<?php
$this->pageTitle='Diana - Change Password';

$this->breadcrumbs=array(
		'Home'=>Yii::app()->createUrl('site/index'),
		'Change Password'=>''
);

$this->menu=array(
// 		array('label'=>'Show Users', 'url'=>array('index'),'visible'=>Yii::app()->user->isAnyAdmin()),
// 		array('label'=>'Add User', 'url'=>array('create'),'visible'=>Yii::app()->user->isAnyAdmin()),
// 		array('label'=>'View User', 'url'=>array('view', 'id'=>$model->user_id)),
// 		array('label'=>'Edit User', 'url'=>array('update', 'id'=>$model->user_id)),
// 		array('label'=>'Edit preferences', 'url'=>array('editPreferences', 'id'=>$model->user_id)),
// 		array('label'=>'Manage Users', 'url'=>array('admin'),'visible'=>Yii::app()->user->isAdmin()),

);
?>
<div class="form diana_box">
	<h1>
		<?php echo $model->username?>
		Change Password
	</h1>





	<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>false,
)); ?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>
	<div class="row">
		<?php if($model->scenario==='adminChangePassword')
			echo $form->labelEx($model,'oldPassword',array('label'=>'Your password'));
		else
		 		echo $form->labelEx($model,'oldPassword'); ?>
		<?php echo $form->passwordField($model,'oldPassword',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'oldPassword'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'newPassword'); ?>
		<?php echo $form->passwordField($model,'newPassword',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'newPassword'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'RepeatPassword'); ?>
		<?php echo $form->passwordField($model,'RepeatPassword',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'RepeatPassword'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Change'); ?>

	</div>
	<?php $this->endWidget(); ?>
</div>
