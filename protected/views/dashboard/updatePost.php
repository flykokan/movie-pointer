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
    		selector: "textarea",
		theme: "modern",
		plugins: "advlist",
		plugins: "autolink",
		plugins: "lists",
		plugins: "link",
		plugins: "image",
		plugins: "charmap",
		plugins: "print",
		plugins: "preview",
		plugins: "hr",
		plugins: "anchor",
		plugins: "pagebreak",
		plugins: "searchreplace", 
		plugins: "wordcount", 
		plugins: "visualblocks", 
		plugins: "visualchars", 
		plugins: "code", 
		plugins: "fullscreen", 
		plugins: "insertdatetime", 
		plugins: "media", 		
		plugins: "nonbreaking", 
		plugins: "save", 
		plugins: "table", 
		plugins: "contextmenu", 
		plugins: "directionality", 
		plugins: "emoticons", 
		plugins: "template", 
		plugins: "paste", 
		plugins: "textcolor", 
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		toolbar2: "print preview media | forecolor backcolor emoticons",
		image_advtab: true,
		    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]




 	});
	</script>
</HEAD>

<BODY>
<div id="whitebox">

	<h1>Edit page '<?php echo $menu->label; ?> '</h1></br>

	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'menu-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<!-- Edit the menu item Label -->
	<p><strong>Edit the menu item label:</strong>
	<input type="text" name="editedLabel" value="<?php echo $menu->label; ?>">
	</p>

	<!-- Edit the place of the menu item in the menu -->
	<p><strong>Your menu item should appear after:</strong><br>
	<?php foreach ($menus as $m) {
		echo '<input type="radio" name="seq" value='.$m->sequence.' />'.$m->label;
     		}
	?></p>

	<!-- Edit the user roles -->
	<p><strong>Select the user roles to which the page should be visible:</strong></br>
	<?php foreach ($roles as $r) {
		if(in_array($r->role_id, $db_roles))
			echo '<input type="checkbox" class="checkbox2" value='.$r->role_id.' name="role[]" checked />'.$r->description;
		else
			echo '<input type="checkbox" class="checkbox2" value='.$r->role_id.' name="role[]" />'.$r->description;
     	      }
	      echo '</br><input type="checkbox" class="form" id="all" value=All name="checkbox[]" />All';
	      echo '</br><input type="checkbox" class="form" id="loggedIn" value=All name="loggedIn_checkbox[]" />Logged In';
	?>
	</p>



	<!-- Visibility of the menu item -->
	<?php
	if($menu->visible == 1)
		echo '<input type="checkbox" class="form" value=1 name="checkbox[]" checked />Display page in menu';
	elseif($menu->type_id == 1){
		//Check the content of the correspondent 
		if($content == ''){
			echo '<input type="checkbox" class="form" value=1 name="checkbox[]" disabled/>Display page in menu';
		}
		else
			echo '<input type="checkbox" class="form" value=1 name="checkbox[]" />Display page in menu';
	}
	else
		echo '<input type="checkbox" class="form" value=1 name="checkbox[]" />Display page in menu';
	?>
	</br></br>

	<!-- Edit the page content -->
	<?php if($menu->type_id == 1){ ?>
    	<p><strong>Add content to the page:</strong></br>
    	<textarea name="txtarea"><?php echo $content; ?></textarea></p>
	<?php } ?>

    	</br><input type="submit" name="saveEdit" value="Save" />
	
	<?php $this->endWidget(); ?>
	</div>

</div>

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
