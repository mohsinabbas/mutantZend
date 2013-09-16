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
		$form = $this->getSignupForm();
		//Check if the submitted data is POST type
		if($form->isValid($_POST))
		{
			$email = $form->getValue("email");
			$username = $form->getValue("username");
			$password = $form->getValue("password");
			
			//Save the user into the system.
			
		}else{
			
			$this->view->errors = $form->getMessages();
			$this->view->form = $form;
		}
		
		/*//Check if the submitted data is POST type
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
        }*/       
    }

    public function newAction()
    {
		//Get the form.
		$form = $this->getSignupForm();
		
		//Add the form to the view
		$this->view->form = $form;
    }

    /**
     * Activate Account. Used once the user
     * receives a welcome email and decides to authenticate
     * their account.
     * 
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

	/**
	* Create the sign up form.
	*/
    private function getSignupForm()
    {
		//Create Form
		$form = new Zend_Form();
		$form->setAction('success');
		$form->setMethod('post');
		$form->setAttrib('sitename', 'loudbite');
		
		//Add Elements
		//Create Username Field.
		$form->addElement('text', 'username');
		$usernameElement = $form->getElement('username');
		$usernameElement->setLabel('Username:');
		$usernameElement->setOrder(1)->setRequired(true);
		
		//Add validator
		$usernameElement->addValidator(
		new Zend_Validate_StringLength(6, 20)
		);
		
		//Add Filter
		$usernameElement->addFilter(new Zend_Filter_StringToLower());
		$usernameElement->addFilter(new Zend_Filter_StripTags());
		
		//Create Email Field.
		$form->addElement('text', 'email');
		$emailElement = $form->getElement('email');
		$emailElement->setLabel('Email:');
		$emailElement->setOrder(3)->setRequired(true);
		
		//Add Validator
		$emailElement->addValidator(new Zend_Validate_EmailAddress());
		
		//Add Filter
		$emailElement->addFilter(new Zend_Filter_StripTags());
		
		//Create Password Field.
		$form->addElement('password', 'password');
		$passwordElement = $form->getElement('password');
		$passwordElement->setLabel('Password:');
		$passwordElement->setOrder(2)->setRequired(true);
		
		//Add Validator
		$passwordElement->addValidator(new Zend_Validate_StringLength(6,20));
				
		//Add Filter
		$passwordElement->addFilter(new Zend_Filter_StripTags());
		$form->addElement('submit', 'submit');
		$submitButton = $form->getElement('submit');
		$submitButton->setLabel('Create My Account!');
		$submitButton->setOrder(4);
		
		return $form;
    }


}











