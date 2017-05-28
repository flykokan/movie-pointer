<?php
/* @var $this SiteController 
 * created at :05 Nov 2013
 * @author Penny Georgiou
*/

$this->pageTitle=Yii::app()->name;

?>

<!-- Load Search Widget -->
<?php $this->widget('Search');?>

<!--<div class="searchBox">
	<form action="<?=Yii::app()->createUrl('site/'.	Yii::app()->controller->action->id);?>" method="post" >
	<?php echo "&nbsp&nbsp"; ?>
	<input type="image" id="search_image" src='img/search.png'/>
	<input type="text" id="search_input" name="keyword" />
	</form>
</div> -->


<?php
$this->renderPartial('_movieSearchResults', array('movies'=>$movies));
?>
