<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<?php //print_r($movies); ?>

<?php
foreach($movies as $m): ?>
	<div id='movie_box'>
 		<table>
			<tr>
			<td><?php echo "<input type='image' src='" . $m->imdb . "'/ valign='top' ></td>"; ?>
			<td><?php echo "<h3>" . $m->title . "</h3>" . $m->synopsis; ?></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
				<?php echo "</br><strong>Rate this movie </strong>" . $rating; ?>

   				<div id="r1" class="rate_widget"> 
					<div class="star_1 ratings_stars2">
						<form action="<?=Yii::app()->createUrl('site/movieRating');?>" method="post" >
						<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
						<input type="hidden" name="ratingStar2" value=1 />
                        			<input type="image" src='images/white-star-md.png'/>
						</form>
					</div> 
	 				<div class="star_2 ratings_stars2">
						<form action="<?=Yii::app()->createUrl('site/movieRating');?>" method="post" >
						<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
						<input type="hidden" name="ratingStar2" value=2 />
                        			<input type="image" src='images/white-star-md.png'/>
						</form>
					</div> 
	 				<div class="star_3 ratings_stars2">
						<form action="<?=Yii::app()->createUrl('site/movieRating');?>" method="post" >
						<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
						<input type="hidden" name="ratingStar2" value=3 />
                        			<input type="image"  src='images/white-star-md.png'/>
						</form>
					</div> 
	 				<div class="star_4 ratings_stars2">
						<form action="<?=Yii::app()->createUrl('site/movieRating');?>" method="post" >
						<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
						<input type="hidden" name="ratingStar2" value=4 />
                        			<input type="image" src='images/white-star-md.png'/>
						</form>
					</div>  
	 				<div class="star_5 ratings_stars2">
						<form action="<?=Yii::app()->createUrl('site/movieRating');?>" method="post" >
						<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
						<input type="hidden" name="ratingStar2" value=5 />
                        			<input type="image" src='images/white-star-md.png'/>
						</form>
					</div>   
    				</div>  
			</td>
			</tr>

			<tr>
			<td></td>
			<td>
				<form action="<?=Yii::app()->createUrl('site/movieRating');?>" method="post" >
					</br><p class="left"><?php echo "Not seen this movie "; ?></p>
					<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
					<input type="hidden" name="not_seen" value='not_seen' />
                        		<input type="image" class="left" src='images/movie_not_seen.png'/>
				</form>
			</td>
			</tr>

			<tr>
			<td></td>
			<td>
				<form action="<?=Yii::app()->createUrl('site/movieRating');?>" method="post" >
					<p class="left"><?php echo "Add to watchlist "; ?></p>
					<?php echo '<input type="hidden" name="movie_id" value="'.$m->mp_id.'" />'; ?>
					<input type="hidden" name="watchlist_add" value='watchlist_add' />
                        		<input type="image" class="left" src='images/add_to_watchlist.png'/>
				</form>
			</td>
			</tr>

		</table> 
	</div>






<!--
<br><br><br><br><br>
-->






<?php endforeach; ?>


						<form action="<?=Yii::app()->createUrl('site/movieRating');?>" method="post" >
						<p>test: 
						<input type="hidden" name="ratingStar2" value="hello" />
                        			<input type="image" src='images/movie_not_seen.png'/></p>
						</form>



