<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
//$this->breadcrumbs=array(
//	'About',
//);
?>


<div id="whitebox">
<h1>User ratings</h1>

<?php //print_r($model->search()); ?>
<?php //echo count($model->search()); ?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	   		'dataProvider' => $model->search(), 
	    		//'filter' => $model,
	    		'columns' => array(
	        		array(
	           			'name' => 'mp_id',
	        			'header' => 'Movie ID',
	            			'value' => 'CHtml::encode($data->mp_id)'
	        		),
				array(
	        			'header' => 'Title',
	        			'value' => '($data->mp_id_obj->title)',
				),
				array(
					'name'=>'user_id',
	        			'header' => 'User ID',
	        			'value' => '($data->user_id)',
				),
				array(
	        			'header' => 'Username',
	        			'value' => '($data->user_id_obj->username)',
				),
				array(
					'name'=>'last_change',
	        			'header' => 'Timestamp',
	        			'value' => '($data->last_change)',
				),
				array(
					'name'=>'rating',
	        			'header' => 'Rating',
	        			'value' => '($data->rating)',
				),
				array(
					'name'=>'not_seen',
	        			'header' => 'Not seen',
	        			'value' => '($data->not_seen)',
				),
				array(
					'name'=>'add_to_watchlist',
	        			'header' => 'Watchlist',
	        			'value' => '($data->add_to_watchlist)',
				),
				/*array(
					'class'=>'CButtonColumn',
					'buttons'=> array('delete' => array('visible'=>'false'),
							  'edit' => array('visible'=>'false'))

				),*/
	    		),
		));
?>

</div>


