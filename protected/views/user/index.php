<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
		'Home'=>Yii::app()->createUrl('site/index'),
		'index'=>'',
);


$this->pageTitle=Yii::app()->name.' - Users';
?>
<div class="diana_box">
	<h1>Users</h1>

	<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
)); ?>
</div>
