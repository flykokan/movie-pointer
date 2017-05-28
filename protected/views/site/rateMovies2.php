<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<h1>Rate the following movies: </h1>

<!-- Effort 1: Rate with radio buttons -->
<!-- The problem is that the radio button does not trigger the controller action -->
<div id="emotion">
	<input type="radio" name="emotion" id="sad" value="I'm sad" />
        <label for="sad"><img src="images/star_highlight.png" alt="I'm sad" /></label>

    	<input type="radio" name="emotion" id="happy" value="I'm happy" />
       	<label for="happy"><img src="images/star_full.png" alt="I'm happy" /></label>
	
</div>

<script>
/*$('#emotion input:radio').addClass('input_hidden');*/
$('#emotion label').click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');
});
</script>

</br></br>

<!-------------------------------------------------------------------------------------------------------------------------->
<!-- Effort 2: Rate with clickable star images -->
<!-- The problem is that the radio button does not trigger the controller action -->
</br>
<?php echo "Rating: " . $rating; ?>

    <div id="r1" class="rate_widget"> 
	 <div class="star_1 ratings_stars">
		<form action="<?=Yii::app()->createUrl('site/rate');?>" method="post" >
			<input type="hidden" name="ratingStar" value=1 />
                        <input type="image" src='images/star_empty.png'/>
		</form>
	</div> 
	 <div class="star_2 ratings_stars">
		<form action="<?=Yii::app()->createUrl('site/rate');?>" method="post" >
			<input type="hidden" name="ratingStar" value=2 />
                        <input type="image" src='images/star_empty.png'/>
		</form>
	</div> 
	 <div class="star_3 ratings_stars">
		<form action="<?=Yii::app()->createUrl('site/rate');?>" method="post" >
			<input type="hidden" name="ratingStar" value=3 />
                        <input type="image"  src='images/star_empty.png'/>
		</form>
	</div> 
	 <div class="star_4 ratings_stars">
		<form action="<?=Yii::app()->createUrl('site/rate');?>" method="post" >
			<input type="hidden" name="ratingStar" value=4 />
                        <input type="image" src='images/star_empty.png'/>
		</form>
	</div>  
	 <div class="star_5 ratings_stars">
		<form action="<?=Yii::app()->createUrl('site/rate');?>" method="post" >
			<input type="hidden" name="ratingStar" value=5 />
                        <input type="image" src='images/star_empty.png'/>
		</form>
	</div>   
    </div>  


</br></br>

<!-------------------------------------------------------------------------------------------------------------------------->
<!-- Effort 3: jQuerry for stars changing color -->
<!-- The problem is that the images are loaded from the css so, they cannot be clickable -->

<div class='movie_choice'>  
    Rate: Raiders of the Lost Ark  
    <div id="r1" class="rate_widget"> 
        <div class="star_1 ratings_stars"></div>  
        <div class="star_2 ratings_stars"></div>  
        <div class="star_3 ratings_stars"></div>  
        <div class="star_4 ratings_stars"></div>  
        <div class="star_5 ratings_stars"></div>  
        <div class="total_votes">vote data</div> 
    </div>  
</div>  
  
<div class='movie_choice'>  
    Rate: The Hunt for Red October  
    <div id="r2" class="rate_widget">  
        <div class="star_1 ratings_stars"></div>  
        <div class="star_2 ratings_stars"></div>  
        <div class="star_3 ratings_stars"></div>  
        <div class="star_4 ratings_stars"></div>  
        <div class="star_5 ratings_stars"></div>  
        <div class="total_votes">vote data</div>  
    </div>  
</div> 

<script>
$('.ratings_stars').hover(  
    // Handles the mouseover  
    function() {  
        $(this).prevAll().andSelf().addClass('ratings_over');  
        $(this).nextAll().removeClass('ratings_vote');   
    },  
    // Handles the mouseout  
    function() {  
        $(this).prevAll().andSelf().removeClass('ratings_over');  
        set_votes($(this).parent());  
    }  
); 


</script>




