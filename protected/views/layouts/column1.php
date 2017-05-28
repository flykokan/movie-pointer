<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
	<div class="content_area" id="content"> 
	<?php echo $content; ?>
	</div>
	<div class="personal_area" id="personal_area">
		<?php $this->widget('PersonalArea');?>
	</div><!-- content -->
<?php $this->endContent(); ?>	
		