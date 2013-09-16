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
        $email = $this->_request->getParam("email");
        $username = $this->_request->getParam("username");
        $password = $this->_request->getParam("password");
        
        //Initiate the SaveAccount model.        
        require_once "SaveAccount.php";
        $SaveAccount = new SaveAccount();
        $SaveAccount->saveAccount($username, $password, $email);
        
        }else{
        throw new Exception("Whoopss. Wrong way of submitting your information.");
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

    public function updateAction()
    {
        //Check if the user is logged in
		//Get the user's id
		//Get the user's information
		//Create the Zend_View object
		$view = new Zend_View();
		//Assign variables if any
		$view->setScriptPath(APPLICATION_PATH . "views/scripts/account");
		$this->render("update");
		
		
		//working for view 
		//$this->renderScript('account/update.phtml');
		
    }


}









