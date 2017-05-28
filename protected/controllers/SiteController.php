<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This function loads static pages dynamically
	 */
	public function actionLoadStaticPage()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$label=$_GET['label'];
		$menu_id=MenuItem::model()-> findByAttributes(array('label'=>$label))->menu_id;
		$static_page=StaticPage::model()-> findByAttributes(array('menu_id'=>$menu_id));
		$content=$static_page->content;

		$this->render('staticPages',array('content'=>$content));
	}

	public function actionLoadFamousLists()
	{
		//if the user has no user rights, redirect to login page
		$this->checkUserRights(Yii::app()->controller->action->id);

		//Select the list titles
		$criteria=new CDbCriteria;
		$criteria->select=' distinct(label) '; 
		//$criteria->condition=" mp_id in (select mp_id from movie_list where label='".$label."' )";
		//$criteria->order=" mp_id";
		$labels=MovieList::model()->findAll($criteria);

		$this->render('famousLists', array('labels'=>$labels));
	}

	public function actionLoadMovieList()
	{
		//if the user has no user rights, redirect to login page
		if(Yii::app()->user->isGuest)
			$this->redirect(array('site/login'));

		//Get the label of the list to be loaded
		$label=$_GET['label'];

		//Select the movies that correspond to this list
		$criteria=new CDbCriteria;
		$criteria->select=' * '; 
		$criteria->condition=" mp_id in (select mp_id from movie_list where label='".$label."' )";
		$criteria->order=" mp_id";
		$movies=Movie::model()->findAll($criteria);

		// renders the view file 'protected/views/site/movieLists.php'
		$this->render('movieLists',array('label'=>$label, 'movies'=>$movies));
	}

	public function actionLoadBlogPosts()
	{
		//if the user has no user rights, redirect to login page
		$this->checkUserRights(Yii::app()->controller->action->id);

		//Select all the active blog posts
		$criteria=new CDbCriteria;
		$criteria->select=' * ';  
		/*$criteria->join=' INNER JOIN static_page p ON t.post_id=p.post_id ';
		$criteria->condition=" visible=1";
		$criteria->order=" sequence";*/

		$blog_posts=BlogPost::model()->findAll();

		// renders the view file 'protected/views/site/movieLists.php'
		$this->render('blogPosts', array('blog_posts'=>$blog_posts));

	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];

			if($model->validate())
			{
				/*$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				$test=$_POST['ContactForm'];	

				//mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);*/

				//Save the data in a temporary table
				$model->name=$_POST['ContactForm']['name'];
				$model->email=$_POST['ContactForm']['email'];
				$model->subject=$_POST['ContactForm']['subject'];
				$model->body=$_POST['ContactForm']['body'];
				$model->answered=0;
				if($model->save()){
					//$mail=EmailManager::getInstance();
					//$mail->emailWebmaster("Contact:".$model->subject,$model->body);
					Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
					$this->refresh();
				}
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the menu items page of Dashboard
	 */
	public function actionManageRequests()
	{
		$model=new ContactRequest('search');
		$model->unsetAttributes();  // clear any default values

		$this->render('manageRequest',array('model'=>$model));

	}

	
	public function actionUpdateContactRequest($id)
	{
		$model=ContactRequest::model()->findByPk($id);

		$test='';

		if(isset($_POST['saveEdit'])){
			$test='123';
			$model->answered=1;
			if($model->save()){
				Yii::app()->user->setFlash('message','The request has been updated successfully.');
				$this->redirect(array('site/manageRequests'));
			}
		}

		$this->render('updateContactRequest', array('model'=>$model, 'test'=>$test));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				echo "<script type=\"text/javascript\">";
    			$x = CHtml::ajax(array(
    			'url'=>CController::createUrl('site/log_valid'),
    			'type'=>'POST',
    			'datatype'=>'html',
     			'update' =>'#personal_area' ));
				echo $x;
    			echo "</script>";
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Displays the about page
	 */
	public function actionAbout()
	{
		// display the about page
		$this->render('about');
	}

	/**
	 * Displays the Dashboard page
	 */
	public function actionDashboard()
	{
		$msg='';$changes=array();
		$menus = MenuItem::model()-> findAll();

		if(isset($_POST['checkbox'])){
   			$msg=$_POST['checkbox'];
			$changes= array_values($_POST['checkbox']);
			foreach($menus as $m){
				if($m->visible == 0 and in_array($m->label, $changes)){
					$m->visible = 1;
				}
				elseif($m->visible == 1 and !(in_array($m->label, $changes))){
					$m->visible = 0;
				}
				$m->update();
			}
			
		}

		// display dashboard
		$this->render('dashboard', array('menus'=>$menus, 'changes'=>$changes, 'msg'=>$msg));
	}

	public function actionLog_valid()
	{
		$this->renderPartial('_personal_area',array(),false,true);
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			Yii::app()->user->logout();
			echo "<script type=\"text/javascript\">";
    		$x = CHtml::ajax(array(
    		'url'=>CController::createUrl('site/log_valid'),
    		'type'=>'POST',
    		'datatype'=>'html',
     		'update' =>'#personal_area' ));
			echo $x;
    		echo "</script>";
			$this->redirect(Yii::app()->user->returnUrl);
		}
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->user->returnUrl);
		
	}


	/*public function actionRate()
	{
		//if the user has no user rights, redirect to login page
		$this->checkUserRights(Yii::app()->controller->action->id);

		$emotion='';
		if(isset($_POST['ratingStar'])){
			$emotion=$_POST['ratingStar'];
		}

		if(isset($_POST['clickable'])){
			$emotion="!!!!!!!!" . $_POST['clickable'];
		}

		$this->render('rateMovies', array('emotion'=>$emotion));
	}*/

	public function actionMovieRating()
	{
		//if the user has no user rights, redirect to login page
		$this->checkUserRights(Yii::app()->controller->action->id);

// Edo thelei anti gia 350 kapoio noumero pou na lambanei ypopsi poses exei dei o xristis (dld na metraei to max oswn DEN exei bathmologisei)	
		
		if(!isset($_POST['ratingStar2'])&&!isset($_POST['not_seen'])&&!isset($_POST['watchlist_add']))
		{
		$total_movies_cnt=Movie::model()->count();
		$criteria=new CDbCriteria;
		$criteria->condition="user_id=".Yii::app()->user->getId()." and (not_seen=1 or rating!=0) ";
		$movies_rated_cnt=count(UserRating::model()->findAll($criteria));
		$end_lim = 25;
		$start_lim = rand(0, $total_movies_cnt-$movies_rated_cnt-$end_lim);
		   	 	
		$criteria=new CDbCriteria;
		$criteria->select=' * ';    
		//$criteria->group="application_id";
//		$criteria->condition=" mp_id not in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()." ) limit 40";
		$criteria->condition=" mp_id not in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()." and (not_seen=1 or rating!=0)) limit $start_lim, $end_lim";
		//$criteria->order=" mp_id";
		$movies=Movie::model()->findAll($criteria); 
		}
		//$movies=array_merge($movies,$this->selected_movies);

		if(isset($_POST['ratingStar2'])){
			if($existing_user_rating=UserRating::model()->findByPk(array('user_id'=>Yii::app()->user->getId(),'mp_id'=>$_POST['movie_id'])))
			{
				$existing_user_rating->rating=$_POST['ratingStar2'];
				$movies_ids=$_POST['cur_movies'];
				$key = array_search($_POST['movie_id'], $movies_ids); 
	 			$last_mp_id=end($movies_ids);
	 			if($existing_user_rating->update()){
	 				unset($movies_ids[$key]);
					$criteria=new CDbCriteria;
					$criteria->select=' * ';  
					$criteria->condition=" mp_id not in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()." and (not_seen=1 or rating!=0)) and mp_id > ".$last_mp_id;
					if($nmovie=Movie::model()->find($criteria))
						array_push($movies_ids,$nmovie->mp_id);
					$nmovies=Movie::model()->findAllByPk($movies_ids);
					$this->updateLog($existing_user_rating);
					$this->renderPartial('movieRatings', array('movies'=>$nmovies));
				}
				Yii::app()->end();
			}
			else
			{
				$model_user_rating = new UserRating();
				$model_user_rating->user_id = Yii::app()->user->getId();
				$model_user_rating->mp_id=$_POST['movie_id'];	
				$model_user_rating->rating=$_POST['ratingStar2'];
				$model_user_rating->not_seen=0;
				$model_user_rating->add_to_watchlist=0;
				$movies_ids=$_POST['cur_movies'];
				$key = array_search($_POST['movie_id'], $movies_ids); 
				$last_mp_id=end($movies_ids);
	 			if($model_user_rating->save()){
	 				unset($movies_ids[$key]);
					$criteria=new CDbCriteria;
					$criteria->select=' * ';  
					$criteria->condition=" mp_id not in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()." and (not_seen=1 or rating!=0)) and mp_id > ".$last_mp_id;
					if($nmovie=Movie::model()->find($criteria))
						array_push($movies_ids,$nmovie->mp_id);
					$nmovies=Movie::model()->findAllByPk($movies_ids);
					$this->updateLog($model_user_rating);
					$this->renderPartial('movieRatings', array('movies'=>$nmovies));
				}
				Yii::app()->end();
			}
		}

		if(isset($_POST['not_seen'])){
			if($existing_user_rating=UserRating::model()->findByPk(array('user_id'=>Yii::app()->user->getId(),'mp_id'=>$_POST['movie_id'])))
			{
				$existing_user_rating->not_seen=1;
				$movies_ids=$_POST['cur_movies'];
				$key = array_search($_POST['movie_id'], $movies_ids); 
	 			$last_mp_id=end($movies_ids);
	 			if($existing_user_rating->update()){
	 				unset($movies_ids[$key]);
					$criteria=new CDbCriteria;
					$criteria->select=' * ';  
					$criteria->condition=" mp_id not in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()." and (not_seen=1 or rating!=0)) and mp_id > ".$last_mp_id;
					if($nmovie=Movie::model()->find($criteria))
						array_push($movies_ids,$nmovie->mp_id);
					$nmovies=Movie::model()->findAllByPk($movies_ids);
					$this->updateLog($existing_user_rating);
					$this->renderPartial('movieRatings', array('movies'=>$nmovies));
				}
				Yii::app()->end();
			}
			else {
				$model_user_rating = new UserRating();
				$model_user_rating->user_id = Yii::app()->user->getId();
				$model_user_rating->mp_id=$_POST['movie_id'];	
				$model_user_rating->rating=0;
				$model_user_rating->not_seen=1;
				$model_user_rating->add_to_watchlist=0;
				$movies_ids=$_POST['cur_movies'];
				$key = array_search($_POST['movie_id'], $movies_ids); 
				$last_mp_id=end($movies_ids);
	 			if($model_user_rating->save()){
	 				unset($movies_ids[$key]);
					$criteria=new CDbCriteria;
					$criteria->select=' * ';  
					$criteria->condition=" mp_id not in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()." and (not_seen=1 or rating!=0)) and mp_id > ".$last_mp_id;
					if($nmovie=Movie::model()->find($criteria))
						array_push($movies_ids,$nmovie->mp_id);
					$nmovies=Movie::model()->findAllByPk($movies_ids);
					$this->updateLog($model_user_rating);
					$this->renderPartial('movieRatings', array('movies'=>$nmovies));
				}
				Yii::app()->end();
			}
		}

		if(isset($_POST['watchlist_add'])){
			if($existing_user_rating=UserRating::model()->findByPk(array('user_id'=>Yii::app()->user->getId(),'mp_id'=>$_POST['movie_id'])))
			{
				$movies_ids=$_POST['cur_movies'];
				if($existing_user_rating->add_watchlist==0)
				{
					$existing_user_rating->add_watchlist=1;
					$key = array_search($_POST['movie_id'], $movies_ids); 
	 				$last_mp_id=end($movies_ids);
	 				if($existing_user_rating->update()){
		 				unset($movies_ids[$key]);
						$criteria=new CDbCriteria;
						$criteria->select=' * ';  
						$criteria->condition=" mp_id not in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()." and (not_seen=1 or rating!=0)) and mp_id > ".$last_mp_id;
						if($nmovie=Movie::model()->find($criteria))
							array_push($movies_ids,$nmovie->mp_id);
						$nmovies=Movie::model()->findAllByPk($movies_ids);
						$this->updateLog($existing_user_rating);
						$this->renderPartial('movieRatings', array('movies'=>$nmovies));
					}
					Yii::app()->end();
				}
				else {
						$existing_user_rating->add_watchlist=0;
						if($existing_user_rating->update()){
							$nmovies=Movie::model()->findAllByPk($movies_ids);
							$this->updateLog($existing_user_rating);
							$this->renderPartial('movieRatings', array('movies'=>$nmovies));
							}
						Yii::app()->end();
					}
			}
			else {
				$model_user_rating = new UserRating();
				$model_user_rating->user_id = Yii::app()->user->getId();
				$model_user_rating->mp_id=$_POST['movie_id'];	
				$model_user_rating->rating=0;
				$model_user_rating->not_seen=0;
				$model_user_rating->add_to_watchlist=1;
				$movies_ids=$_POST['cur_movies'];
				$key = array_search($_POST['movie_id'], $movies_ids); 
				$last_mp_id=end($movies_ids);
	 			if($model_user_rating->save()){
	 				unset($movies_ids[$key]);
					$criteria=new CDbCriteria;
					$criteria->select=' * ';  
					$criteria->condition=" mp_id not in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()." and (not_seen=1 or rating!=0)) and mp_id > ".$last_mp_id;
					if($nmovie=Movie::model()->find($criteria))
						array_push($movies_ids,$nmovie->mp_id);
					$nmovies=Movie::model()->findAllByPk($movies_ids);
					$this->updateLog($model_user_rating);
					$this->renderPartial('movieRatings', array('movies'=>$nmovies));
				}
				Yii::app()->end();
			}
		}

		$this->render('movieRatings', array('movies'=>$movies));
	}


	public function actionShowRatings()
	{	
		//if the user has no user rights, redirect to login page
		if(Yii::app()->user->isGuest)
			$this->redirect(array('site/login'));
		
		if(!isset($_POST['ratingStar2'])&&!isset($_POST['watchlist_add'])&&!isset($_POST['not_seen']))
		{
			$criteria=new CDbCriteria;
			$criteria->select=' * ';  // only select
			//$criteria->group="application_id";
			$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()
						." and rating>0 )";
			$criteria->order=" title";
			$movies=Movie::model()->findAll($criteria);
			
			//Get the user ratings from the DB
			//$user_ratings=$this->getUserRatings();
		}
		//Update the movie rating
		if(isset($_POST['ratingStar2'])){
			//$this->updateRating($_POST['movie_id'], $_POST['ratingStar2']);
			$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(),'mp_id'=>$_POST['movie_id']));
			$model_user_rating->rating=$_POST['ratingStar2'];	
			$model_user_rating->not_seen=0;	
					
			if($model_user_rating->update()){
				$criteria=new CDbCriteria;
				$criteria->select=' * ';  // only select
				//$criteria->group="application_id";
				$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()
							." and rating>0 )";
				$criteria->order=" title";
				$movies=Movie::model()->findAll($criteria);
				
				//Get the user ratings from the DB
				//$user_ratings=$this->getUserRatings();
		
				$this->updateLog($model_user_rating);
				$this->renderPartial('_userRatings', array('movies'=>$movies));
			}
			Yii::app()->end();
		}

		//Update the watchlist attribute
		if(isset($_POST['watchlist_add'])){
			//$this->updateWatchlist($_POST['movie_id']);
		$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(),'mp_id'=>$_POST['movie_id']));
			if($model_user_rating->add_to_watchlist==1)
				$model_user_rating->add_to_watchlist=0;
			else
				$model_user_rating->add_to_watchlist=1;
			if($model_user_rating->update()){
				$criteria=new CDbCriteria;
				$criteria->select=' * ';  // only select
				//$criteria->group="application_id";
				$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()." and rating>0 )";
				$criteria->order=" title";
				$movies=Movie::model()->findAll($criteria);
				
				//Get the user ratings from the DB
				//$user_ratings=$this->getUserRatings();
		
				$this->updateLog($model_user_rating);
				$this->renderPartial('_userRatings', array('movies'=>$movies));
			}
			Yii::app()->end();
		}

		//Update the not_seen attribute
		if(isset($_POST['not_seen'])){
			//$this->updateNotSeen($_POST['movie_id']);
			$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(), 'mp_id'=>$_POST['movie_id']));
			$model_user_rating->not_seen=1;
			$model_user_rating->rating=0;
				if($model_user_rating->update()){
					$criteria=new CDbCriteria;
					$criteria->select=' * ';  // only select
					//$criteria->group="application_id";
					$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()
								." and rating>0 )";
					$criteria->order=" title";
					$movies=Movie::model()->findAll($criteria);
					
					//Get the user ratings from the DB
					//$user_ratings=$this->getUserRatings();
		
					$this->updateLog($model_user_rating);
			$this->renderPartial('_userRatings', array('movies'=>$movies));
			}
			Yii::app()->end();
		}

		$this->render('userRatings', array('movies'=>$movies));
	}

	public function actionShowWatchlist()
	{
		//if the user has no user rights, redirect to login page
		if(Yii::app()->user->isGuest)
			$this->redirect(array('site/login'));

		if(!isset($_POST['ratingStar2'])&&!isset($_POST['watchlist_add'])&&!isset($_POST['not_seen']))
		{
			$criteria=new CDbCriteria;
			$criteria->select=' * ';  
			$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()
						." and add_to_watchlist=1 )";
			$criteria->order="title";
			$movies=Movie::model()->findAll($criteria);
		}

		//Get the user ratings from the DB
		//$user_ratings=$this->getUserRatings();

		if(isset($_POST['ratingStar2'])){
			//$this->updateRating($_POST['movie_id'], $_POST['ratingStar2']);
			if(isset($_POST['ratingStar2'])){
				$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(),'mp_id'=>$_POST['movie_id']));
				$model_user_rating->rating=$_POST['ratingStar2'];	
				$model_user_rating->not_seen=0;	
					
				if($model_user_rating->update()){
					$criteria=new CDbCriteria;
					$criteria->select=' * ';  // only select
					//$criteria->group="application_id";
						$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()
					." and add_to_watchlist=1 )";
					$criteria->order=" title";
					$movies=Movie::model()->findAll($criteria);
					
					//Get the user ratings from the DB
					//$user_ratings=$this->getUserRatings();
			
					$this->updateLog($model_user_rating);
					$this->renderPartial('_userWatchlist', array('movies'=>$movies));
				}
				Yii::app()->end();
				//$this->updateRating($_POST['movie_id'], $_POST['ratingStar2']);
			}
		}

		//Update the not_seen attribute
		if(isset($_POST['not_seen'])){
			//$this->updateNotSeen($_POST['movie_id']);
			$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(), 'mp_id'=>$_POST['movie_id']));
			$model_user_rating->not_seen=1;
			$model_user_rating->rating=0;
			if($model_user_rating->update()){
				$criteria=new CDbCriteria;
				$criteria->select=' * ';  // only select
				//$criteria->group="application_id";
				$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()
				." and add_to_watchlist=1 )";
				$criteria->order=" title";
				$movies=Movie::model()->findAll($criteria);
					
					//Get the user ratings from the DB
					//$user_ratings=$this->getUserRatings();
		
				$this->updateLog($model_user_rating);
				$this->renderPartial('_userWatchlist', array('movies'=>$movies));
			}
			Yii::app()->end();
		}
		
		if(isset($_POST['watchlist_add'])){
			//$this->updateWatchlist($_POST['movie_id']);
				$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(),'mp_id'=>$_POST['movie_id']));
				$model_user_rating->add_to_watchlist=0;
				if($model_user_rating->update()){
					$criteria=new CDbCriteria;
					$criteria->select=' * ';  // only select
					//$criteria->group="application_id";
					$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()
						." and add_to_watchlist=1 )";
					$criteria->order=" title";
					$movies=Movie::model()->findAll($criteria);
					
					//Get the user ratings from the DB
					//$user_ratings=$this->getUserRatings();
			
					$this->updateLog($model_user_rating);
					$this->renderPartial('_userWatchlist', array('movies'=>$movies));
			}
			Yii::app()->end();
		}
	
		$this->render('userWatchlist', array('movies'=>$movies));
	}

	public function actionShowNotSeen()
	{
		//if the user has no user rights, redirect to login page
		if(Yii::app()->user->isGuest)
			$this->redirect(array('site/login'));
		
		if(!isset($_POST['ratingStar2'])&&!isset($_POST['watchlist_add']))
		{
			$criteria=new CDbCriteria;
			$criteria->select=' * ';  // only select
			//$criteria->group="application_id";
			$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()
						." and not_seen=1 and rating=0 )";
			$criteria->order="title";
			$movies=Movie::model()->findAll($criteria);
	
			//Get the user ratings from the DB
			//$user_ratings=$this->getUserRatings();
			}
			//Update the movie rating
			if(isset($_POST['ratingStar2'])){
				$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(),'mp_id'=>$_POST['movie_id']));
				$model_user_rating->rating=$_POST['ratingStar2'];	
				$model_user_rating->not_seen=0;	
					
				if($model_user_rating->update()){
					$criteria=new CDbCriteria;
					$criteria->select=' * ';  // only select
					//$criteria->group="application_id";
					$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()
						." and not_seen=1 and rating=0 )";
					$criteria->order=" title";
					$movies=Movie::model()->findAll($criteria);
					
					//Get the user ratings from the DB
					//$user_ratings=$this->getUserRatings();
			
					$this->updateLog($model_user_rating);
					$this->renderPartial('_userNotSeen', array('movies'=>$movies));
				}
				Yii::app()->end();
				//$this->updateRating($_POST['movie_id'], $_POST['ratingStar2']);
			}

		//Update the watchlist attribute
			if(isset($_POST['watchlist_add'])){
				$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(),'mp_id'=>$_POST['movie_id']));
				if($model_user_rating->add_to_watchlist==1)
					$model_user_rating->add_to_watchlist=0;
				else
					$model_user_rating->add_to_watchlist=1;
				if($model_user_rating->update()){
					$criteria=new CDbCriteria;
					$criteria->select=' * ';  // only select
					//$criteria->group="application_id";
					$criteria->condition=" mp_id in (select mp_id from user_rating where user_id=".Yii::app()->user->getId()
						." and not_seen=1 and rating=0 )";
					$criteria->order=" title";
					$movies=Movie::model()->findAll($criteria);
					
					//Get the user ratings from the DB
					//$user_ratings=$this->getUserRatings();
			
					$this->updateLog($model_user_rating);
					$this->renderPartial('_userNotSeen', array('movies'=>$movies));
				}
				Yii::app()->end();
			}

		$this->render('userNotSeen', array('movies'=>$movies));
	}


	public function actionShowSharedRatings()
	{
		//Get the label of the list to be loaded
		$user_id=$_GET['user_id'];
		$user=User::model()->findByAttributes(array('user_id'=>$user_id));

		//Select the movies that correspond to this list
		$criteria=new CDbCriteria;
		$criteria->select=' * '; 
		$criteria->condition=" mp_id in (select mp_id from user_rating where user_id='".$user_id."' and rating>0 )";
		$criteria->order=" mp_id";
		$movies=Movie::model()->findAll($criteria);

		//Get the user ratings from the DB
		//$user_ratings=$this->getUserRatings();


		// renders the view file 'protected/views/site/movieLists.php'
		$this->render('sharedRatings',array(/*'user_id'=>$user_id,*/ 'user'=>$user, 'movies'=>$movies));

	}

	public function actionMovieSearch()
	{
		//if the user has no user rights, redirect to login page
		$this->checkUserRights(Yii::app()->controller->action->id);

		$movies=array();
		if(isset($_POST['keyword'])){
			//Search the movie title 
			$criteria=new CDbCriteria;
			$criteria->select=' * '; 
			$criteria->condition=" title='".$_POST['keyword']."'";
			$criteria->order=" mp_id";
			$movies=Movie::model()->findAll($criteria); 

		//If there is no exact match for the title, search for similar titles
		if($movies==null){
			$criteria->condition=" title like '%".$_POST['keyword']."%'";
			$movies=Movie::model()->findAll($criteria); 
		}

		if($movies==null)
			Yii::app()->user->setFlash('message','There are no movies for these criteria.');
		}

		$this->render('movieSearch', array('movies'=>$movies));

	}

	private function checkUserRights($action){

		$criteria=new CDbCriteria;
		$criteria->select=' role_id '; 
		$criteria->condition=" menu_id in (select menu_id from menu_item where action='".$action."' )";
		$criteria->order=" role_id";
		$roles=MenuRole::model()->findAll($criteria);

		if(!Yii::app()->user->isGuest){
			$role=User::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
			$user_role=$role->role_id;
		}
		else
			$user_role=0;

		$roles_list=array();
		foreach($roles as $r)
			array_push($roles_list, $r->role_id);

		if(!in_array($user_role, $roles_list))
			$this->redirect(array('site/login'));

	}

	private function getUserRatings()
	{
		$criteria=new CDbCriteria;
		$criteria->select=' * ';  
		$criteria->condition=" user_id=".Yii::app()->user->getId()." and rating>0";
		$user_ratings=UserRating::model()->findAll($criteria);
		
		return $user_ratings;
	}
	
	
	private function getUserRatingsOld()
	{
		$criteria=new CDbCriteria;
		$criteria->select=' * ';  
		$criteria->condition=" user_id=".Yii::app()->user->getId();
		$res=UserRating::model()->findAll($criteria);

		$user_ratings=array();
		foreach($res as $r){
			if($r->rating>0)
				$user_ratings[$r->mp_id]=$r->rating;
		}
		
		return $user_ratings;
	}

	private function updateRating($movie_id, $curr_rating)
	{
		$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(), 
			'mp_id'=>$movie_id));
		$model_user_rating->rating=$curr_rating;	
		$model_user_rating->not_seen=0;			
		if($model_user_rating->update()){
			$this->updateLog($model_user_rating);
			$this->renderPartial('movieRatings', array('movies'=>$nmovies, 'rating'=>$rating, 'user_ratings'=>$user_ratings));
		}
	}

	private function updateWatchlist($movie_id)
	{
		$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(), 
			'mp_id'=>$movie_id));
		$model_user_rating->add_to_watchlist=1;
		if($model_user_rating->update()){
			$this->updateLog($model_user_rating);
			$this->refresh();
		}
	}

	private function updateNotSeen($movie_id)
	{
		$model_user_rating=UserRating::model()-> findByAttributes(array('user_id'=>Yii::app()->user->getId(), 
			'mp_id'=>$movie_id));
		$model_user_rating->not_seen=1;
		$model_user_rating->rating=0;
		if($model_user_rating->update()){
			$this->updateLog($model_user_rating);
			$this->refresh();
		}
	}

	private function updateLog($model_user_rating)
	{
		$model_user_rating_log = new UserRatingLog();
		$model_user_rating_log->user_id = $model_user_rating->user_id;
		$model_user_rating_log->mp_id= $model_user_rating->mp_id;
		$model_user_rating_log->rating= $model_user_rating->rating;
		$model_user_rating_log->not_seen= $model_user_rating->not_seen;
		$model_user_rating_log->add_to_watchlist= $model_user_rating->add_to_watchlist;

		if($model_user_rating_log->save()){
			//$this->refresh();
		}
	}
	
	public function actionUpdateMovies()
	{
		//if(isset($_POST['ratingStar2']))
		//{
			$ratingStar2=$_POST['ratingStar2'];
			$this->renderPartial('_update_movies',array('ratingStar2'=>$ratingStar2));
		//}
		//else
//			$this->renderPartial('_update_movies');
	}
}
