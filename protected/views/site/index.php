<?php
/* @var $this SiteController 
 * created at :05 Nov 2013
 * @author Penny Georgiou
*/

$this->pageTitle=Yii::app()->name;

//Load content from DB 
//$menu_id=MenuItem::model()-> findByAttributes(array('label'=>'Home'))->menu_id;
$menu_id=MenuItem::model()-> findByAttributes(array('menu_id'=>1))->menu_id;
$static_page=StaticPage::model()-> findByAttributes(array('menu_id'=>$menu_id));
echo $static_page->content;

?>


