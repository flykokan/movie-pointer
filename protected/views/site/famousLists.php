<?php
/* @var $this SiteController 
 * created at :05 Nov 2013
 * @author Penny Georgiou
*/

$this->pageTitle=Yii::app()->name;

foreach($labels as $l)
	echo "</br><a href=".Yii::app()->createUrl('site/LoadMovieList', array('label'=>$l->label)).">".$l->label."</a>";

?>


