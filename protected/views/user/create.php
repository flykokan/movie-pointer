<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle=Yii::app()->name . ' - SignUp';
//$this->breadcrumbs=array(
//	'SignUp',
//);

?>

	<h1>Become a Member Now!</h1>

	<?php echo $this->renderPartial('_form', array('user_model'=>$user_model)); ?>
