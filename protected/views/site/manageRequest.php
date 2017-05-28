<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
/*$this->breadcrumbs=array(
	'About',
);*/
?>

<div class="whitebox">
<h1>Admin: Manage Requests</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	   		'dataProvider' => $model->search(), 
	    		//'filter' => $model,
	    		'columns' => array(
				'subject',
				array(
					'name'=>'answered',
	        			'header' => 'Answered',
	        			'value' => '($data->answered==1?"Yes":"No")',
				),
				'sent_on',
				array(
					'class'=>'CButtonColumn',
					'buttons'=> array('delete' => array('visible'=>'false'),
							  'view' => array('visible'=>'false'),
 							  'update' => array('url' => 'CController::createUrl("/site/updateContactRequest", array("id"=>$data->request_id))'),

					)

				),

	    		),
		));
?>

</div>




