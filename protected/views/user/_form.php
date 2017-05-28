<div class="form">

	<p class="note">
	Fields with <span class="required">*</span> are required.
	</p>

	<?php echo CHtml::errorSummary($user_model); ?>
		
	<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>false,
			)); ?>

			<div class="row">
				<?php echo $form->labelEx($user_model,'username'); ?>
				<?php echo $form->textField($user_model,'username',array('size'=>40,'maxlength'=>40)); ?>
				<?php echo $form->error($user_model,'username'); ?>
			</div>
		
			<div class="row">
					<?php echo $form->labelEx($user_model,'password'); ?>
					<?php echo $form->passwordField($user_model,'password',array('size'=>40,'maxlength'=>40)); ?>
					<?php echo $form->error($user_model,'password'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($user_model,'RepeatPassword'); ?>
					<?php echo $form->passwordField($user_model,'RepeatPassword',array('size'=>40,'maxlength'=>40)); ?>
					<?php echo $form->error($user_model,'RepeatPassword'); ?>
				</div>
			
			<div class="row">
				<?php echo $form->labelEx($user_model,'email'); ?>
				<?php echo $form->textField($user_model,'email',array('size'=>40,'maxlength'=>64)); ?>
				<?php echo $form->error($user_model,'email'); ?>
			</div>
			
			<div class="row buttons">
				<?php echo CHtml::submitButton('Create'); ?>
			</div>
			
	<?php $this->endWidget(); ?>
</div>


