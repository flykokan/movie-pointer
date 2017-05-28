<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

//$this->pageTitle=Yii::app()->name . ' - Contact Us';
//$this->breadcrumbs=array(
//	'Contact',
//);
?>

<script>
$(document).ready(function(){
	var rating=0;
	<?php if(Yii::app()->controller->action->id == "movieRating"): ?>
		$('.ratings_stars2').on('click', function() {
				$(this).children('.ratesubmit').first().submit();
		});
		$('.ratings_stars2').hover(  
    	// Handles the mouseover  
    		function() {
         		$(this).prevAll('.ratings_stars2').andSelf().find('input[type="image"]').attr("src",'img/heart_full.png');  
    		},  
    	// Handles the mouseout  
    		function() {
    	 		$(this).prevAll('.ratings_stars2').andSelf().find('input[type="image"]').attr("src",'img/heart_empty.png');    
    		}  
		);
	<?php elseif(Yii::app()->controller->action->id != "showSharedRatings"): ?>
		$('.ratings_stars2').on('click', function() {
				$(this).children('.ratesubmit').first().submit();
		});
		
		$('.ratings_stars2').hover(  
    	// Handles the mouseover  
    		function() {
    			rating=0;
    			$(this).siblings().andSelf().each(function() {
  					if($(this).find('input[type="image"]').attr("src")=='img/heart_full.png')
  						rating++;
				});
         		$(this).prevAll('.ratings_stars2').andSelf().find('input[type="image"]').attr("src",'img/heart_full.png'); 
				$(this).nextAll('.ratings_stars2').find('input[type="image"]').attr("src",'img/heart_empty.png');
    		},  
    	// Handles the mouseout  
    		function() {
    				$(this).prevAll('.ratings_stars2').andSelf().find('input[type="image"]').attr("src",'img/heart_empty.png'); 
    	 		    $(this).parent('#stars_block').children('.ratings_stars2').slice(0,rating).find('input[type="image"]').attr("src",'img/heart_full.png');
    		}  
		);
	<?php endif; ?>	
});
</script>

<?php //echo Yii::app()->controller->action->id; //echo "</br>" . Yii::app()->controller->action->id; ?>
<? // php echo "</br>".Yii::app()->user->getId(); //print_r($res); ?>

<?php

foreach($movies as $m): ?>
	<div id='movie_box'>
	
	
	<div id='movie_title'>
	<?php echo "<p class='movie_title'>" . $m->title . " (" . $m->year .")</p></span>"; ?>
	
	</div>
	
	<div id='movie_photo'>
	<?php echo "<img src='" . $m->imdb . "' />"; ?>
	</div>
	
	<div id='movie_features_box'>
	
<!-- STARS -->
	<div id='stars_block'>
	
				<?php if($user_ratings!=NULL && array_key_exists($m->mp_id,$user_ratings)): ?>
					
						<?php for ($i=1; $i<=5; $i++){ ?>
						<div class="ratings_stars2">
							<!-- This part should not be a form in case of shared ratings -->
							<?php if(Yii::app()->controller->action->id != "showSharedRatings"): ?>
								<form action="<?=Yii::app()->createUrl('site/'.
									Yii::app()->controller->action->id);?>" method="post" >
								<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
								<?php echo '<input type="hidden" name="ratingStar2" value='.$i.'/>'; ?>
								<?php if($i<=$user_ratings[$m->mp_id]): ?>
                        					<input type="image" src='img/heart_full.png'/>
								<?php else: ?>
                        					<input type="image" src='img/heart_empty.png'/>
								<?php endif; ?>
								</form>
							<?php else: ?>
								<?php if($i<=$user_ratings[$m->mp_id]): ?>
                        					<img src='img/heart_full.png'/>
								<?php else: ?>
                        					<img src='img/heart_empty.png'/>
								<?php endif; ?>
							<?php endif; ?>	
						</div> 
						<?php } ?>

				<?php else: ?>
				
					<?php //echo "<strong>Rate this movie </strong>" . $rating; ?>
										
						<?php for ($i=1; $i<=5; $i++){ ?>
						<div class="ratings_stars2">
							<form class="ratesubmit" action="<?=Yii::app()->createUrl('site/'.
								Yii::app()->controller->action->id);?>" method="post" >
							<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
							<?php echo '<input type="hidden" name="ratingStar2" value='.$i.'/>'; ?>
                        				<input type="image" src='img/heart_empty.png'/>
							</form>
						</div> 
						<?php } ?>
				<?php endif; ?>	
	
	</div>
	
<!-- END STARS -->



<!-- NOT SEEN -->
<!-- Not to be displayed  in the case of shared ratings -->
<?php if(Yii::app()->controller->action->id != "showSharedRatings"): ?>
	<div id='notseen_block'>
  <p class='notseen_label'>I Have Not Seen It</p>
				<form action="<?=Yii::app()->createUrl('site/'.Yii::app()->controller->action->id);?>" method="post" >
					
					<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
					<input type="hidden" name="not_seen" value='not_seen' />
                        		<input type="image" class="left" src='img/movie_not_seen.png'/>
				</form>

	</div>
<?php endif; ?>
<!-- END NOT SEEN -->



<!-- WATCHLIST -->
<!-- Not to be displayed  in the case of shared ratings -->
<?php if(Yii::app()->controller->action->id != "showSharedRatings"): ?>
	<div id='watchlist_block'>
  <p class='notseen_label'>Add To Watchlist</p>

				<form action="<?=Yii::app()->createUrl('site/'.Yii::app()->controller->action->id);?>" method="post" >
					<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
					<input type="hidden" name="watchlist_add" value='watchlist_add' />
          <input type="image" class="left" src='img/watchlist.png'/>
				</form>

	</div>
<?php endif; ?>
<!-- END WATCHLIST -->

</div>

	<div id='movie_synopsis'>
	<?php echo "<p>" . $m->synopsis; ?>
	</div>

</div>


<!--
<br><br><br><br><br>
-->



<?php endforeach; ?>

<!--
						<form action="<?=Yii::app()->createUrl('site/movieRating');?>" method="post" >
						<p>test: 
						<input type="hidden" name="ratingStar2" value="hello" />
                        			<input type="image" src='images/movie_not_seen.png'/></p>
						</form>
						
-->
