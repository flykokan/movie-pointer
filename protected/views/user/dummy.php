<?php
/* @var $this UserController */
/* @var $model User */

echo CHtml::dropDownList('country_id','', array(1=>'USA',2=>'France',3=>'Japan'),
array(
'ajax' => array(
'type'=>'POST', //request type
'url'=>CController::createUrl('user/dynamiccities'), //url to call.
//Style: CController::createUrl('currentController/methodToCall')
'sucess'=>'alert("hello")', //selector to update
//'data'=>'js:javascript statement' 
//leave out the data key to pass all form values through
))); 
 
//empty since it will be filled by the other dropdown
echo CHtml::dropDownList('city_id','', array());


?>