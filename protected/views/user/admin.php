<?php
/* @var $this UserController */
/* @var $model User */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('doc-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>
<div class="box">
	<h1>Manage Users</h1>

	<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
	<div class="search-form" style="display: none">
		<?php $this->renderPartial('_search',array(
				'model'=>$model,
)); ?>
	</div>
	<!-- search-form -->

	<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'user-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
		//'user_id',
		'username',
		'email',
		array(
			'name'=>'role_id',
	        'header' => 'Role',
	        'value' => '($data->role_id==1?"Admin":"User")',
		),
		array(
			'name'=>'approved',
	        'header' => 'approved',
	        'value' => '($data->approved==1?"yes":"no")',
		),
		array(
			'class'=>'CButtonColumn',
			'buttons'=> array('delete' => array('visible'=>'false'))
		),
	),
)); ?>
<p>
		You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>,
		<b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the
		beginning of each of your search values to specify how the comparison
		should be done. For sorting , click on the corresponding header.
	</p>
</div>
