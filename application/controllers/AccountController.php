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
		$email = $this->_request->getParam('email');
		$username = $this->_request->getParam('username');
		$password = $this->_request->getParam('password');
		
		//Save the user into the system.        
    }

    public function newAction()
    {
        // action body
    }

    public function activateAction()
    {
        // action body
    }


}







