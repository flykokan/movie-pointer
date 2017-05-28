<?php

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<h1>Rate the movies:</h1>

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
