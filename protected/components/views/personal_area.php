<?php if (Yii::app()->user->isGuest): ?>
	<div class="box">
    	<div class="box_header">
    	Register	
	</div>
		<a href="<?=Yii::app()->createUrl("user/create")?>">Become a Member</a><br>
		<a href="<?=Yii::app()->createUrl("site/login")?>">Login</a>
	</div>
<?php else:?>
	<?php $user=Yii::app()->user->loadUser();?>
<div class="box">
    <div class="box_header">
    Welcome <b style="color:#000"><?php echo Yii::app() -> user -> name; ?></b>
    
    </div> 
	<a href="<?=Yii::app()->createUrl("site/logout")?>">Logout</a>
	</br><a href="<?=Yii::app()->createUrl('user/edit', array('id'=>User::model()->findByAttributes(array('username'=>Yii::app() -> user -> name))->user_id))?>">Edit Profile</a>
		
		</br><a href="<?=Yii::app()->createUrl('site/showRatings')?>">My ratings</a>
		</br><a href="<?=Yii::app()->createUrl('site/showWatchlist')?>">My watchlist</a>
		</br><a href="<?=Yii::app()->createUrl('site/showNotSeen')?>">Not seen by me</a>
		</br><a href="<?=Yii::app()->createUrl('site/showSharedRatings', array('user_id'=>Yii::app()->user->id))?>">Shared ratings</a>
</div>
		<?php if (Yii::app()->user->isAdmin()): ?>
		<div class="box">
			<div class="box_header">
				Dashboard
		</div>
            
	<a href="<?php echo Yii::app()->createUrl('user/admin')?>">Manage Users</a>
	<br><a href="<?php echo Yii::app()->createUrl('dashboard/manageContent')?>">Manage content</a>
	<br><a href="<?php echo Yii::app()->createUrl('dashboard/manageRatings')?>">Manage ratings</a>
	<br><a href="<?php echo Yii::app()->createUrl('site/manageRequests')?>">Manage requests</a>
	<br><a href="<?php echo Yii::app()->createUrl('dashboard/manageLogs')?>">Manage logs</a>
	<br><a href="<?php echo Yii::app()->createUrl('dashboard/manageBlog')?>">Manage blog posts</a>
	<!--<li><a href="<?php echo Yii::app()->createUrl('dashboard/menuItems')?>">Menu items</a></li>
	<li><a href="<?php echo Yii::app()->createUrl('dashboard/editStaticPages')?>">Static Pages</a></li>-->

             <br>
	</div>
	<?php endif; ?>
<?php endif; ?>
