<?php

class ArtistController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listAllArtistAction()
    {
        // action body
    }

    public function artistaffiliatecontentAction()
    {
        // action body
    }

    public function profileAction()
    {
        // action body
    }

    public function newAction()
    {
        //Get all the genres
		$genres = array("Electronic",
		"Country",
		"Rock",
		"R & B",
		"Hip-Hop",
		"Heavy-Metal",
		"Alternative Rock",
		"Christian",
		"Jazz",
		"Pop");
		//Set the view variables
		$this->view->genres = $genres;		
    }

    public function saveArtistAction()
    {
        //get Posted data 
		$artistName = $this->_request->getPost('artistName');
		$genre = $this->_request->getPost('genre');
		$isFav = $this->_request->getPost('isFav');
		$rating = $this->_request->getPost('rating');
		
		
		//After validation save data in DB
				
		
    }


}













