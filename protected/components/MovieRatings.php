<?php
/**
 * 
 * Created at:Dec 5, 2012
 * description: This class renders the suggestions for all applications.(not yet all)
 * @author Nikos Kostoulas
 */
class MovieRatings extends CWidget{
	
	public $movies;
	
	public function MovieRatings($movies){
		$this->movies=$movies;
	}
	
	
	public function run(){
		$this->render('movieRating', array('movies'=>$this->movies));
	}
	
}
