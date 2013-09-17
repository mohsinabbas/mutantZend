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
		//Fetch the user's id
		//Fetch the users information
		
		//Create the form.
		$form = $this->getUpdateForm();
		//Check if the form has been submitted.
		//If so validate and process.
		
		if($_POST){
			//Check if the form is valid.
			if($form->isValid($_POST)){
				//Get the values
				$username = $form->getValue('username');
				$password = $form->getValue('password');
				$email = $form->getValue('email');
				$aboutMe = $form->getValue('aboutme');
				
				//Save the file
				$form->avatar->receive();
				//Save.
			}
			//Otherwise redisplay the form.
			else{
				$this->view->form = $form;
			}
		}
		//Otherwise display the form.
		else{
			$this->view->form = $form;
		}
		
		
        //Check if the user is logged in
		//Get the user's id
		//Get the user's information
		//Create the Zend_View object
	//	$view = new Zend_View();
		//Assign variables if any
	//	$view->setScriptPath(APPLICATION_PATH . "views/scripts/account");
	//	$this->render("update");
		
		
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
		require APPLICATION_PATH."/models/Form/Elements.php";
		$LoudbiteElements = new Elements();
		
		//Create Username Field.
		$form->addElement($LoudbiteElements->getUsernameTextField());
		//Create Email Field.
		$form->addElement($LoudbiteElements->getEmailTextField());
		//Create Password Field.
		$form->addElement($LoudbiteElements->getPasswordTextField());
		//Add Captcha
		$captchaElement = new Zend_Form_Element_Captcha('signup',array(
																	'captcha' => array(
																					'captcha' => 'Figlet',
																					'wordLen' => 4,
																					'timeout' => 600))
																					);
		$captchaElement->setLabel('Please type in the words below to continue');
		$form->addElement($captchaElement);
		$form->addElement('submit', 'submit');
		$submitButton = $form->getElement('submit');
		$submitButton->setLabel('Create My Account!');
		
		return $form;
		
		
		/*//Create Form
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
		
		return $form;*/
    }
	
	
	/**
	* Update Form
	*/
	private function getUpdateForm()
	{
		//Create Form
		$form = new Zend_Form();
		$form->setAction('update');
		$form->setMethod('post');
		$form->setAttrib('sitename', 'loudbite');
		$form->setAttrib('enctype', 'multipart/form-data');
		//Load Elements class
		require APPLICATION_PATH."/models/Form/Elements.php";
		$LoudbiteElements = new Elements();
		
		//Create Username Field.
		$form->addElement($LoudbiteElements->getUsernameTextField());
		//Create Email Field.
		$form->addElement($LoudbiteElements->getEmailTextField());
		//Create Password Field.
		$form->addElement($LoudbiteElements->getPasswordTextField());
		//Create Text Area for About me.
		$textAreaElement = new Zend_Form_Element_TextArea('aboutme');
		$textAreaElement->setLabel('About Me:');
		$textAreaElement->setAttribs(array('cols' => 15,
		'rows' => 5));
		$form->addElement($textAreaElement);
		//Add File Upload
		$fileUploadElement = new Zend_Form_Element_File('avatar');
		$fileUploadElement->setLabel('Your Avatar:');
		$fileUploadElement->setDestination('../public/users');
		$fileUploadElement->addValidator('Count', false, 1);
		$fileUploadElement->addValidator('Extension', false, 'jpg,gif');
		$form->addElement($fileUploadElement);
		//Create a submit button.
		$form->addElement('submit', 'submit');
		$submitElement = $form->getElement('submit');
		$submitElement->setLabel('Update My Account');
		
		return $form;
	}
		


}
