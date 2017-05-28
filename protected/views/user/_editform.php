<div class="form">


	<?php echo CHtml::errorSummary(array($user_model)); ?>
		
	<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>false,
			)); ?>
	
			<div class="row">
				<?php echo $form->labelEx($user_model,'email'); ?>
				<?php echo $form->textField($user_model,'email',array('size'=>40,'maxlength'=>64)); ?>
				<?php echo $form->error($user_model,'email'); ?>
			</div>
			
			<br>
			<div class="row buttons">
				<?php echo CHtml::submitButton('Save'); ?>
			</div>
			
	<?php $this->endWidget(); ?>
</div>


