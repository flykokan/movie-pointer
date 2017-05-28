<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>


<div id="whitebox">
<h1>Create New Page</h1>
<p>This is a test div that will change completely later on....</p>
</div><br>

<div id="whitebox">
<h1>Edit Menu Items</h1>

 <?php print_r($roles_selected); ?> 

<form method="post">
<?php foreach ($menus as $m) {
	if($m->visible == 0)
		echo '<input type="radio" name="editLabel" value='.$m->menu_id.' />'.$m->label.' <em>(not in menu)</em></br>';
	else
		echo '<input type="radio" name="editLabel" value='.$m->menu_id.' />'.$m->label.'</br>';
      }
?>

    	</br><input type="submit" name="editMenu" value="Edit" />
	<input type="submit" name="createMenu" value="Create new" />
	</form></br></br>
</div>

<!-- Editing Menu Item -->
<?php
if($menu != '' and $menu != 'new'){ ?>

	<form method="post">
	Label: <input type="text" name="editedLabel"><br>

	<!--<br>Your menu item should appear after:<br>
	<?php foreach ($menus as $m) {
		echo '<input type="radio" name="seq" value='.$m->sequence.' required/>'.$m->label;
     		}
	?><br><br> -->

	<?php
	if($menu->visible == 1)
		echo '<input type="checkbox" class="form" value=1 name="checkbox[]" checked />Visible';
	elseif($menu->type_id == 1){
		//Check the content of the correspondent 
		if($content == ''){
			echo '<input type="checkbox" class="form" value=1 name="checkbox[]" disabled/>Visible';
		}
		else
			echo '<input type="checkbox" class="form" value=1 name="checkbox[]" />Visible';
	}
	else
		echo '<input type="checkbox" class="form" value=1 name="checkbox[]" />Visible';
	?>
	<input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
    	</br><input type="submit" name="saveEdit" value="Save" />
	</form>
<?php
}
?>

<!-- Creating Menu Item -->
<?php
if($menu == 'new'){ ?>

	<form method="post">
	Label: <input type="text" name="label" required><br>

	<br>Your menu item should appear after:<br>
	<?php foreach ($menus as $m) {
		echo '<input type="radio" name="seq" value='.$m->sequence.' required/>'.$m->label;
     		}
	?><br>

	<br>Select the roles that should see this menu item:<br>
	<?php foreach ($roles as $r) {
		echo '<input type="checkbox" class="checkbox2" value='.$r->role_id.' name="role[]" />'.$r->description;
     		}
	      echo '</br><input type="checkbox" class="form" id="all" value=All name="checkbox[]" />All';
	      echo '</br><input type="checkbox" class="form" id="loggedIn" value=All name="checkbox[]" />Logged In';
	?>

    	<br><br><input type="submit" name="saveCreate" value="Save"/>
	</form>

<?php
}
?>


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
