<?php
/* @var $this UserController */
/* @var $model User */



$this->pageTitle=Yii::app()->name.' - Edit Profile ';;
?>
<div class="box">
	<h1>
		Edit Profile (<?php echo $user_model->username; ?>)
	</h1>

	<?php echo $this->renderPartial('_editform', array('user_model'=>$user_model)); ?>
</div>
