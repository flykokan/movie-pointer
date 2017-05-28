<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
?>

<h1>Not seen movies</h1>

<?php
$this->renderPartial('_userNotSeen', array('movies'=>$movies));

?>

