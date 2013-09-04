<?php

class AccountController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function successAction()
    {
	//Check if the submitted data is POST type
        if($this->_request->isPost()){
        $email = $this->_request->getPost("email");
        $username = $this->_request->getPost("username");
        $password = $this->_request->getPost("password");
        //Save the user into the system.
        }else{
        throw new Exception("Whoops. Wrong way of submitting your information.");
        }       
    }

    public function newAction()
    {
        // action body
    }
    
    /**
    * Activate Account. Used once the user
    * receives a welcome email and decides to authenticate
    * their account.
    *
    */

    public function activateAction()
    {
        //Fetch the email to update from the query param 'email'
        $emailToActivate = $this->_request->getQuery("email");
        //Check if the email exists
        //Activate the Account.
        echo $emailToActivate;
        
    }


}







