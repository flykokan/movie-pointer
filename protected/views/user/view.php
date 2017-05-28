<?php
/* @var $this UserController */
/* @var $model User */


?>
<div class="box">
	<h1>
		View User 
		<?php echo $model->username; ?>
	</h1>
    
    <?php if(Yii::app()->user->hasFlash('message')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
    <?php endif;?>
    
	<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
			'user_id',
			'username',
			'email',
			'created_at',
	),
)); ?>
</div>
