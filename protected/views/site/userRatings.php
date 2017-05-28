<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
?>

<h1>You have rated the following movies</h1>

<?php $this->renderPartial('_userRatings', array('movies'=>$movies));?>

