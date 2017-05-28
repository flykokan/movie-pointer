<?php
    /**
     * Resets the password of a user. Sents him an email with a link to reset his password.
     * We use the table diana_request to accomplish this task.
     * The type is reset_password the user_id is the user's id and the status AWAITING_APPROVAL.
     * When the reset is done status becomes approved and the reset cannot be reused.
     * The unique id is stored in the internal_description field and is valid for 24 hours.
     */
     $this->breadcrumbs=array(
            'Home'=>Yii::app()->createUrl('site/index'),
            'Reset Password'=>"",
            );
     $this->pageTitle=Yii::app()->name."- Reset Password";
     ?>
     
     
    <div class="diana_box">
        <h1>Reset your password</h1>
        <p>Please enter below your username. You will receive an email containing a link to the reset password page.</p>
    </br>
    <?php
     $this -> renderPartial('_reset_form', array('model' => $model)); 
    ?>
    </div>