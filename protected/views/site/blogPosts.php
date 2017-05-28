<?php
/* @var $this SiteController 
 * created at :05 Nov 2013
 * @author Penny Georgiou
*/

$this->pageTitle=Yii::app()->name;
?>


<?php foreach($blog_posts as $post): ?>
	<div id='blog_post'>
		<?php echo $post->label; ?>
	</div>
<?php endforeach; ?>




