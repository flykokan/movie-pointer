<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
//$this->breadcrumbs=array(
//	'About',
//);
?>


<div id="whitebox">
<h1>Create New Page</h1>
<p>Please click  <a href="index.php?r=dashboard/createNewPage">here</a> in order to create a new static page.</p>
</div><br>

<div id="whitebox">
<h1>Edit Existing Pages</h1>

<?php //print_r($model->search()); ?>
<?php //echo count($model->search()); ?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	   		'dataProvider' => $model->search(), 
	    		//'filter' => $model,
	    		'columns' => array(
	        		array(
	           			'name' => 'label',
	        			'header' => 'Label',
	            			'value' => 'CHtml::encode($data->label)'
	        		),
				array(
					'name'=>'visible',
	        			'header' => 'Visible',
	        			'value' => '($data->visible==1?"Yes":"No")',
				),
				/*array(
					'name'=>'visible2',
	        			'header' => 'Visible 2',
	        			'value' => '($test->visible==1?"Yes":"No")',
				),*/
				array(
					'class'=>'CButtonColumn',
					'buttons'=> array('delete' => array('visible'=>'false'),
							  'view' => array('visible'=>'false'))

				),
	    		),
		));
?>

</div>


