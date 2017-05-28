<div class="searchBox">
	<form action="<?=Yii::app()->createUrl('site/'.	Yii::app()->controller->action->id);?>" method="post" >
	<?php echo "&nbsp&nbsp"; ?>
	<input type="image" id="search_image" src='img/search.png'/>
	<input type="text" id="search_input" name="keyword" />
	</form>
</div> 
