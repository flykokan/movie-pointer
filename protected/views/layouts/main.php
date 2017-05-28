<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	
	<link rel="shortcut icon" href="img/MP_16_16.jpg">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<!-- Register jQuerry -->
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>

<div class="container" id="page">

	<?php $this->widget('Header');?>

	<div id="mainmenu">
		<?php 
			//Find the user role. If not logged in, role is user.
			if(!Yii::app()->user->isGuest)
				$user_role=User::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId()))->role_id;
			else
				$user_role=0;

			//Find which menu items should be visible to the user according to his role
			$menu_items=array(); $menus=array();
			$visible_menus = MenuItem::model()->findAll(array("condition"=>"visible=1","order"=>"sequence"));
			$role_menus=MenuRole::model()->findAllByAttributes(array('role_id'=>$user_role));
			foreach($role_menus as $r){
				array_push($menus, $r->menu_id);
			}

			//Load the menu items & the corresponding pages
			foreach($visible_menus as $m){
				if(in_array($m->menu_id, $menus)){
					//$m_lower=strtolower($m->label);
					/*if(strcmp($m->label,"Map1") == 0)
						$menu_item=array('label'=>'Map1', 'url'=>array('/site/map1'));
					if(strcmp($m->label,"Map2") == 0)
						$menu_item=array('label'=>'Map2', 'url'=>array('/site/map2'));
					if(strcmp($m->label,"Map3") == 0)
						$menu_item=array('label'=>'Map3', 'url'=>array('/site/map3'));*/

					if($m->type_id == 1 )
						$menu_item=array('label'=>$m->label, 'url'=>CController::createUrl('site/loadStaticPage', 
									array('label'=>$m->label)));
					else
						$menu_item=array('label'=>$m->label, 'url'=>CController::createUrl('/site/'.$m->action));
					array_push($menu_items,$menu_item);
				}
			}
			$this->widget('zii.widgets.CMenu',array(

			'items'=>$menu_items,

		)); ?>
	</div><!-- mainmenu -->


	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>


<!-- Messages -->
<div class="message_box" >
	<?php if(Yii::app()->user->hasFlash('message')){ ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('message'); }?>
</div>
<div class="message_box" >
	<?php if(Yii::app()->user->hasFlash('error')){ ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('error'); }?>
</div>


	<?php echo $content; ?>

	<div class="clear"></div> 

	<?php $this->widget('Footer');?>

</div><!-- page -->

</body>
</html>
