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
		//Check if the user is logged in.
		//Set the view variables
		$this->view->form = $this->getAddArtistForm();

        /*//Get all the genres
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
		$this->view->genres = $genres;*/		
    }

    public function saveArtistAction()
    {
        //get Posted data 
		$artistName = $this->_request->getPost('artistName');
		$genre = $this->_request->getPost('genre');
		$isFav = $this->_request->getPost('isFav');
		$rating = $this->_request->getPost('rating');
		
		//1. method to change escape function
		//Override default escape
		/*$this->view->setEscape('strip_tags');*/
		
		//2. method to change escape function properties by making new class
		//Set new escape function to use.
		require "utils/Escape.php";
		$escapeObj = new Escape();
		$this->view->setEscape(array($escapeObj, "doEnhancedEscape"));
		
		
		
		//Clean up inputs
		$artistName = $this->view->escape($artistName);
		$genre = $this->view->escape($genre);
		$rating = $this->view->escape($rating);
		$isFav = $this->view->escape($isFav);
		
		
		//After validation save data in DB
				
		
    }
	
	/**
	* Create Add Artist Form.
	*
	* @return Zend_Form
	*/
	private function getAddArtistForm()
	{
		$form = new Zend_Form();
		$form->setAction("saveartist");
		$form->setMethod("post");
		$form->setName("addartist");
		
		//Create artist name text field.
		$artistNameElement = new Zend_Form_Element_Text('artistName');
		$artistNameElement->setLabel("Artist Name:");
		
		//Create genres select menu
		$genres = array("multiOptions" => array(
												"electronic" => "Electronic",
												"country" => "Country",
												"rock" => "Rock",
												"r_n_b" => "R & B",
												"hip_hop" => "Hip-Hop",
												"heavy_metal" => "Heavy-Metal",
												"alternative_rock" => "Alternative Rock",
												"christian" => "Christian",
												"jazz" => "Jazz",
												"pop" => "Pop"
												));
		$genreElement = new Zend_Form_Element_Select('genre', $genres);
		$genreElement->setLabel("Genre:");
		
		$genreElement->setRequired(true);
		//Create favorite radio buttons.
		$favoriteOptions = array("multiOptions" => array(
														"1" => "yes",
														"0" => "no"
														));
		$isFavoriteListElement = new Zend_Form_Element_Radio('isFavorite', $favoriteOptions);
		$isFavoriteListElement->setLabel("Add to Favorite List:");
		$isFavoriteListElement->setRequired(true);
		
		//Create Rating raio button
		$ratingOptions = array("multiOptions" => array(
													"1" => "1",
													"2" => "2",
													"3" => "3",
													"4" => "4",
													"5" => "5"
													));
		$ratingElement = new Zend_Form_Element_Radio('rating', $ratingOptions);
		$ratingElement->setLabel("Rating:");
		$ratingElement->setRequired(true)->addValidator(new Zend_Validate_Alnum(false));
		
		//Create submit button
		$submitButton = new Zend_Form_Element_Submit("submit");
		$submitButton->setLabel("Add Artist");
		
		//Add Elements to form
		$form->addElement($artistNameElement);
		$form->addElement($genreElement);
		$form->addElement($isFavoriteListElement);
		$form->addElement($ratingElement);
		$form->addElement($submitButton);

		return $form;
	}
	


    public function newsAction()
    {
        
		//Check if the user is logged in
		//Get the user's Id
		//Get the artists. (Example uses static artists)
		$artists = array("Thievery Corporation",
						 "The Eagles",
						 "Elton John");
		
		//Set the view variables
		$this->view->artists = $artists;
		
		$view = new Zend_View();
		//Find the view in our new location
		$view->setScriptPath("views/scripts/artist/");
		$this->render("news");
		
		//$this->renderScript('artist/news.phtml');
		
    }

    public function removeAction()
    {
        //Check if the user is logged in
		//Get the user's Id
		
		//Three methods for setting variables in view
		//1. //Get the user's artists.
				/*$artists = array("Thievery Corporation",
								 "The Eagles",
								 "Elton John");
				//Set the view variables
				$this->view->totalArtist = count($artists);
				$this->view->artists = $artists;*/
		
		//2. //Get the user's artists.
			/*$artists = array("Thievery Corporation", "The Eagles", "Elton John");
			//Set the total number of artists in the array.
			//Demonstrates the use of a key-value array assignment.
			$totalNumberOfArtists = array("totalArtist" => count($artists));
			//Set the view variables
			$this->view->assign("artists", $artists);
			$this->view->assign($totalNumberOfArtists);*/
		
		
		//3.//Get the user's artists.
			//Get the user's artist with rating.
			$artists = array(
							array("name" => "Thievery Corporation", "rating" => 5),
							array("name" => "The Eagles", "rating" => 5),
							array("name" => "Elton John", "rating" => 4)
						);
			//Set the total number of artists in the array.
			//Demonstrates the use of a key-value array assignment.
			$totalNumberOfArtists = array("totalArtist" => count($artists));
			//Create the class
			$artistObj = new StdClass();
			$artistObj->artists = $artists;
			/*//Set the total number of artists in the array.
			//Demonstrates the use of a key-value array assignment.
			$totalNumberOfArtists = array("totalArtist" => count($artists));*/
			//Set the view variables
			$this->view->assign((array)$artistObj);
			$this->view->assign($totalNumberOfArtists);
		
    }


}

















