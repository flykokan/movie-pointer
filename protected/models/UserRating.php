<?php

class UserRating extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MenuItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function scopes()
	{

	}


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_rating';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'mp_id_obj' => array(self::BELONGS_TO, 'Movie', 'mp_id'),
			'user_id_obj' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{

	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('mp_id',$this->mp_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('rating',$this->rating,true);
		$criteria->compare('not_seen',$this->not_seen,true);
		$criteria->compare('add_to_watchlist',$this->add_to_watchlist,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['pagination_static_pages'],//'10',
			),
		));
	}

	public function isRated($user_id,$mp_id)
	{
		if($user_rating=UserRating::model()->findByPK(array('user_id'=>$user_id,'mp_id'=>$mp_id)))
		{
			if($user_rating->rating>0)
				return TRUE;
		}
		return FALSE;
	}
	
	public function isInWatchlist($user_id,$mp_id)
	{
		if($user_rating=UserRating::model()->findByPK(array('user_id'=>$user_id,'mp_id'=>$mp_id)))
		{
			if($user_rating->add_to_watchlist==1)
				return TRUE;
		}
		return FALSE;
	}
	
	public function isInNotSeenList($user_id,$mp_id)
	{
		if($user_rating=UserRating::model()->findByPK(array('user_id'=>$user_id,'mp_id'=>$mp_id)))
		{
			if($user_rating->not_seen==1)
				return TRUE;
		}
		return FALSE;
	}
	
	public function getRating($user_id,$mp_id)
	{
		if($user_rating=UserRating::model()->findByPK(array('user_id'=>$user_id,'mp_id'=>$mp_id)))
		{
			return $user_rating->rating;
		}
	}
}
