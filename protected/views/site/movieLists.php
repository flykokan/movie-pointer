<?php
/* @var $this SiteController 
 * created at :05 Nov 2013
 * @author Penny Georgiou
*/

$this->pageTitle=Yii::app()->name;

echo "<h1>".$label."</h1>";
$this->widget("MovieRatings",array('movies'=>$movies));

?>


