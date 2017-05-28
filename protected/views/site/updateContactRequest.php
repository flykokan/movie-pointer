<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Manage Requests';

?>

<div class="whitebox">

<h1>Admin: Request Management</h1>

<p><strong>Name: </strong> <?php echo " ".$model->name.$test; ?> 
<strong>Email: </strong> <?php echo " ".$model->email; ?> </p>
<p><strong>Sent on: </strong> <?php echo " ".$model->sent_on; ?> </p>
<p><strong>Subject: </strong> <?php echo " ".$model->subject; ?> </p>
<p><strong>Body: </strong> <?php echo " ".$model->body; ?> </p>

<!-- Check whether the request is answered -->
	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'menu-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<?php if($model->answered == 0){
		echo '<input type="checkbox" class="form" value=0 name="checkbox[]" />Check if the request is answered';
    		echo '</br><input class="button_contact_request" type="submit" name="saveEdit" value="Save" />';
	}
	else
		echo '<i>This request is answered</i>'
	?>
	<?php $this->endWidget(); ?>
	</div>

</div>
