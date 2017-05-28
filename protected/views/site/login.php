<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';

/*$this->breadcrumbs=array(
	'Login',
); */
?>

<div class="register_block">
	<h1>Not Registered?</h1>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas molestie mattis nisl ac fermentum. Integer sed eros elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
	<p>Pellentesque non dolor feugiat, venenatis augue nec, venenatis diam. Quisque eleifend, nisi in bibendum viverra, nunc odio volutpat dui, vel porta quam felis ac odio. Vivamus fermentum neque at laoreet scelerisque.</p> 
	<span><a href="<?=Yii::app()->createUrl("user/create")?>">Sign up</a></span>
</div> 



<div class="login_block">
  <h1>Login</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>
	
	<!--<div>
	    <a href="<?=Yii::app()->createUrl("user/resetPassword")?>">Forgot your password?</a>
	</div> -->

<?php $this->endWidget(); ?>
</div><!-- form -->

</div>