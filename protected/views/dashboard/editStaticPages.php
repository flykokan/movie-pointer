<?php
//Register javascript file for interface functions!
$baseUrl = Yii::app() -> baseUrl;
//Get urls
$cs = Yii::app() -> getClientScript();
//Register javascript files
$cs->registerScriptFile($baseUrl.'/js/tinymce/tinymce.min.js');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
   <HEAD>
      <!-- Place inside the <head> of your HTML -->
<script type="text/javascript" src="<your installation path>/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>
   </HEAD>

   <BODY>
<h1>Select Page</h1>
<?php echo "role= "; 
print_r($msg);
 ?>



<form method="post">
	<?php foreach ($menus as $m) {
		if($m->type_id == 1){
			echo '<input type="radio" name="editPage" value='.$m->menu_id.' />'.$m->label.'</br>';
		}
      	}
?>
    </br><input type="submit" name="formSubmit" value="Edit" />
</form>

</br></br>
<h1>Edit Post</h1> <?php echo 'view: '.$menu_id ; ?>

      <!-- Place this in the body of the page content -->
<form method="post">
    <textarea name="txtarea"><?php echo $content; ?></textarea>
<input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
<input type="submit" name="formSubmit" value="Submit" />
</br></br></br>
</form>
   </BODY>
</HTML>



<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>




