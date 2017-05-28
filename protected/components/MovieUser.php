<?php

/**
 *
 * Created at: Mar 9, 2012
 *  Extends the yii cwebuser in order to add admin and group admin validation.
 * @author  Nikos Kostoulas
 *
 */

class MovieUser extends CWebUser{

	protected $_model;

	/**
	 * Check if user is admin. Probably the fleming team will all be admins.
	 */
	function isAdmin(){
		$user = $this->loadUser();
		if ($user)
			return $user->role_id==1;
		return false;
	}

	function isUser(){
		$user=$this->loadUser();
		if($user)
			return $user->role_id==2;
		return TRUE;
	}
	/**
	 * 
	 * Created at:Nov 27, 2012
	 * description: Check whether the user is not a real user but the guest demo user.s
	 * @author Nikos Kostoulas
	 * @return boolean
	 */
	function isGuest(){
		$user=$this->loadUser();
		if($user)
			return FALSE;
		return TRUE;
	}
	
	function isApproved(){
		$user=$this->loadUser();
		if($user)
			return $user->approved==1;
		return FALSE;
	}
	/**
	 * 
	 * Created at:Nov 27, 2012
	 * description: Return wheter the user is allowd to download data from the specific application.
	 * @author Nikos Kostoulas
	 * @param unknown $application
	 * @return boolean
	 */
	/*function canDownload($application){
		$user = $this->loadUser();
		$request=Request::model()->findbyAttributes(array('user_id'=>$user->user_id,'application_id'=>$application,'request_type'=>"DOWNLOAD_DATA"));
		if($request==null)return false;
		else return $request->status=="APPROVED";

	}*/


	// Load user model.
	public function loadUser()
	{
		if ( $this->_model === null ) {
			$this->_model = User::model()->findByPk( $this->id );
		}
		return $this->_model;
	}
}
