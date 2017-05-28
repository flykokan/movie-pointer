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
<div id="whitebox">

	<h1>Create New Page</h1>

	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'menu-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<!-- Insert the menu item Label -->
	<p><strong>Insert the menu item label: </strong><input type="text" name="label" required></p>

	<!-- Define the place of the menu item in the menu -->
	<p><strong>Your menu item should appear after:</strong><br>
	<?php foreach ($menus as $m) {
		echo '<input type="radio" name="seq" value='.$m->sequence.' required/>'.$m->label;
     		}
	?></p>

	<!-- Define the user roles to which the new page will be visible -->
	<p><strong>Select the roles that should see this menu item:</strong><br>
	<?php foreach ($roles as $r) {
		echo '<input type="checkbox" class="checkbox2" value='.$r->role_id.' name="role[]" />'.$r->description;
     		}
	      echo '</br><input type="checkbox" class="form" id="all" value=All name="checkbox[]" />All';
	      echo '</br><input type="checkbox" class="form" id="loggedIn" value=All name="checkbox[]" />Logged In';
	?></p>

	<!-- Add content to the new page -->
    	<p><strong>Add content to the page:</strong></br>
    	<textarea name="txtarea"></textarea></p>

	<!-- Submit Button -->
	<input type="submit" name="saveCreate" value="Create"/>

	<?php $this->endWidget(); ?>
	</div>

</div>

</BODY>
</HTML>

<script>

$('#all').click(function(){
    if (this.checked) {
       // $('p').css('color', '#0099ff');
	$('.checkbox2').prop('checked', true);
    }
    else{
	$('.checkbox2').prop('checked', false);
    }
}) 

$('#loggedIn').click(function(){
    if (this.checked) {
       // $('p').css('color', '#0099ff');
	$('.checkbox2').prop('checked', true);
    }
    else{
	$('.checkbox2').prop('checked', false);
    }
}) 
</script>
