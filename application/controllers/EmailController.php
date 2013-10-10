<?php

/**
* Email Controller. Contains all Chapter 6 examples.
*
* @author <Your Name Here>, <Your Email Address>
* @package Beginning_Zend_Framework
*/

class EmailController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
	
	/**
	* Basic example using default settings.
	*
	*/
	public function sendMailAction()
	{
		//Send out the welcome message
		$MailObj = new Zend_Mail();
		$emailMessage = "Hey, this is a Zend_Mail–created e-mail!";
		$fromEmail = "from@gmail.com";//"<FROM_EMAIL_ADDRESS>";
		$fromFullName = "From full name";//"<FROM_FULL_NAME>";
		$to = 'mohsinpucit@gmail.com';//"<YOUR_EMAIL_HERE>";
		$subject = "This is an example";
		$MailObj->setBodyText($emailMessage);
		$MailObj->setFrom($fromEmail, $fromFullName);
		$MailObj->addTo($to);
		$MailObj->setSubject($subject);
		try{
			$MailObj->send();
		echo "E-mail sent successfully";
		}catch(Zend_Mail_Exception $e){
		//Your Error message here.
		}
		
		//Suppress the view.
		$this->_helper->viewRenderer->setNoRender();
		
	}
	
	/**
	* Send email using SMTP Host.
	*
	*/
	public function smtpSendMailAction()
	{
		//Create SMTP connection Object
		$configInfo = array('auth' => 'login',
							'ssl' => 'tls',
							'username' => 'mohsinpucit@gmail.com',
							'password' => '04203349733611',//'<YOUR SMTP ACCOUNT PASSWORD>',
							'port' => '587'//'<SMTP PORT NUMBER>'
							);
		$smtpHost = new Zend_Mail_Transport_Smtp('<SMTP HOST>',$configInfo);
		
		//Create Zend_Mail object.
		$MailObj = new Zend_Mail();
		//Initialize parameters.
		$emailMessage = "Hey, this is a Zend_Mail–created e-mail!";
		$fromEmail = "FROM_EMAIL_ADDRESS";
		$fromFullName = "FROM_FULL_NAME";
		$to = "YOUR_EMAIL_HERE";
		$subject = "This is an example";
		$MailObj->setBodyText($emailMessage);
		$MailObj->setFrom($fromEmail, $fromFullName);
		$MailObj->addTo($to);
		$MailObj->setSubject($subject);
		
		//Send Email using transport protocol.
		try{
			$MailObj->send($smtpHost);
			echo "Email sent successfully";
		}catch(Zend_Mail_Exception $e){
			//Your error message here.
			echo $e->getMessage();
		}
		
		//Suppress the view.
		$this->_helper->viewRenderer->setNoRender();
		
	}//
	
	/**
	* Send email using SMTP Host and CC.
	*
	*/
	public function sendEmailWithCopyAction()
	{		
		//Create Zend_Mail object.
		$MailObj = new Zend_Mail();
		//Initialize parameters.
		$emailMessage = "Hey, this is a Zend_Mail–created e-mail!";
		$fromEmail = "FROM_EMAIL_ADDRESS";
		$fromFullName = "FROM_FULL_NAME";
		$to = "YOUR_EMAIL_HERE";
		$subject = "This is an example";
		
		$MailObj->setBodyText($emailMessage);
		$MailObj->setFrom($fromEmail, $fromFullName);
		$MailObj->addTo($to);
		$MailObj->addCc('mohsin@gmail.com', 'Mohsin');
		$MailObj->addCc('abbas@gmail.com', 'Abbas');
		
		$MailObj->addBcc('ali@gmail.com');
		$MailObj->addBcc('Ali');

		$MailObj->setSubject($subject);		
		
		//Send Email using transport protocol.
		try{
			$MailObj->send();
			echo "Email sent successfully";
		}catch(Zend_Mail_Exception $e){
			//Your error message here.
			echo $e->getMessage();
		}
		
		//Suppress the view.
		$this->_helper->viewRenderer->setNoRender();
	}
	
	/**
	* Send HTML based email.
	*
	*/
	public function sendHtmlEmailAction()
	{
		//Create SMTP connection
		$configInfo = array('auth' => 'login',
		'ssl' => 'tls',
		'username' => '<YOUR ACCOUNT USERNAME>',
		'password' => '<YOUR SMTP ACCOUNT PASSWORD>',
		'port' => '<SMTP PORT NUMBER>');
		
		$smtpHost = new Zend_Mail_Transport_Smtp('<SMTP HOST>',$configInfo);
		
		//Create Zend_Mail object.
		$MailObj = new Zend_Mail();
		$message = "<h1>Welcome to the example</h1><br>" .
				   "<p>An example email.</p>";
		
		//Initialize parameters.
		$fromEmail = "FROM_EMAIL_ADDRESS";
		$fromFullName = "FROM_FULL_NAME";
		$to = "YOUR_EMAIL_HERE";
		$subject = "This is an example";
		$MailObj->setBodyHtml($message);
		$MailObj->setFrom($fromEmail, $fromFullName);
		$MailObj->addTo($to);
		$MailObj->setSubject($subject);
		
		//Send Email using transport protocol.
		try{
			$MailObj->send($smtpHost);
			echo "Email sent successfully";
		}catch(Zend_Mail_Exception $e){
			//Your Error message here.
		}
		
		//Suppress the view.
		$this->_helper->viewRenderer->setNoRender();
	}
	
	/**
	* Send out email with attachment
	*
	*/
	public function sendEmailWithAttachmentAction()
	{
		//Create SMTP connection
		$configInfo = array('auth' => 'login',
							'ssl' => 'tls',
							'username' => '<YOUR ACCOUNT USERNAME>',
							'password' => '<YOUR SMTP ACCOUNT PASSWORD>',
							'port' => '<SMTP PORT NUMBER>'
							);
		$smtpHost = new Zend_Mail_Transport_Smtp('<SMTP HOST>',$configInfo);
		
		//Create Zend_Mail object.
		$MailObj = new Zend_Mail();
		$message = "<h1>Welcome to the example</h1>".
					"<br><p>An example email.</p>";
		//Read image data.
		$fileLocation = '<PATH TO YOUR FILE>';
		
		//Check if the file exists and is readable
		if(!$fileHandler = fopen($fileLocation, 'rb')){
			throw new Exception("The file could not be found or is not readable.");
		}
		$fileContent = fread($fileHandler, filesize($fileLocation));
		fflush($fileHandler);
		fclose($fileHandler);
		//Initialize parameters.
		$fromEmail = "<FROM_EMAIL_ADDRESS";
		$fromFullName = "<FROM_FULL_NAME>";
		$to = "<YOUR_EMAIL_HERE>";
		$subject = "This is an example";
		$MailObj->setBodyHtml($message);
		$MailObj->setFrom($fromEmail, $fromFullName);
		$MailObj->addTo($to);
		$MailObj->setSubject($subject);
		$MailObj->createAttachment($fileContent,'<MIME TYPE OF FILE>',Zend_Mime::DISPOSITION_ATTACHMENT);
		
		//Send Email using transport protocol.
		try{
			$MailObj->send($smtpHost);
			echo "Email sent successfully";
		}catch(Zend_Mail_Exception $e){
		//Your Error message here.
			echo $e->getMessage();
		}
		
		//Suppress the view.
		$this->_helper->viewRenderer->setNoRender();
	}

	


}

