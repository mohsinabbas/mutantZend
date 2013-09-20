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
		//Create instance of artist form.
		$form = $this->getAddArtistForm();
		
		//Check for logged in status
		if(!isset($_SESSION['id'])){
				$this->_forward("login");
		}
		
		//Check if there were no errors
		if($form->isValid($_POST)){
		
			//Initialize the variables
			$artistName = $form->getValue('artistName');
			$genre = $form->getValue('genre');
			$rating = $form->getValue('rating');
			$isFav = $form->getValue('isFavorite');
			//Set the temporary account id to use.			
			$userId = $_SESSION['id'];
			try{
				//Create a db object
				require APPLICATION_PATH."/models/Db/Db_Db.php";
				$db = Db_Db::conn();
				
				//Initialize data to save into DB
				$artistData = array("artist_name" => $artistName,
									"genre" => $genre,
									"created_date" =>
									new Zend_Db_Expr("NOW()"));
				//Insert the artist into the Db
				$db->insert('artists', $artistData);
				//Fetch the artist id
				$artistId = $db->lastInsertId();
				//Initialize data for the account artists table
				$accountArtistData = array("account_id" => $userId,
											"artist_id" => $artistId,
											"rating" => $rating,
											"is_fav" => $isFav,
											"created_date" => new Zend_Db_Expr("NOW()"));
				//Insert the data.		
				$db->insert('accounts_artists', $accountArtistData);
				$db->commit();
				
			}catch(Zend_Db_Exception $e)
			{
				//If there were errors roll everything back.
				$db->rollBack();
				echo $e->getMessage();
			}
		}else{
		
			$this->view->errors = $form->getMessages();
			$this->view->form = $form;
		}



		
        /*//get Posted data 
		$artistName = $this->_request->getPost('artistName');
		$genre = $this->_request->getPost('genre');
		$isFav = $this->_request->getPost('isFav');
		$rating = $this->_request->getPost('rating');
		
		//1. method to change escape function
		//Override default escape
		//$this->view->setEscape('strip_tags');
		
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
		
		
		//After validation save data in DB*/
				
		
    }

    /**
     * Create Add Artist Form.
     * 
     * @return Zend_Form
     *
     */
    private function getAddArtistForm()
    {
		$form = new Zend_Form();
		$form->setAction("save-artist");
		$form->setMethod("post");
		$form->setName("addartist");
		
		//Create artist name text field.
		$artistNameElement = new Zend_Form_Element_Text('artistName');
		$artistNameElement->setLabel("Artist Name:");
		$artistNameElement->setRequired(true);
		//Add Validator
		$artistNameElement->addValidator(new Zend_Validate_StringLength(6,20));
	
		
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
	
	/**
	* Display all the Artists in the system.
	*/
	public function listAction(){
		
		
		$currentPage = 1;
		//Check if the user is not on page 1
		$i = $this->_request->getQuery('i');
		if(!empty($i)){ //Where i is the current page
		$currentPage = $this->_request->getQuery('i');
		}
		//Create Db object
		require APPLICATION_PATH."/models/Db/Db_Db.php";		
		$db = Db_Db::conn();
		
		//Create a Zend_Db_Select object
		$sql = new Zend_Db_Select($db);
		
		//Define columns to retrieve as well as the table.
		$columns = array("id", "artist_name");
		$table = array("artists");
		
		//SELECT `artists`.`id`, `artists`.`artist_name` FROM `artists`
		$statement = $sql->from($table, $columns);
		//Initialize the Zend_Paginator
		$paginator = Zend_Paginator::factory($statement);
		
		//Set the properties for the pagination
		$paginator->setItemCountPerPage(10);
		$paginator->setPageRange(3);
		$paginator->setCurrentPageNumber($currentPage);
		$this->view->paginator = $paginator;

		
		
		/*1.//Create a sample array of artist
		$artist = array("Underworld", "Groove Armada", "Daft Punk",
						"Paul Oakenfold", "MC Chris", "Ramones",
						"The Beatles", "The Mamas and the Papas",
						"Jimi Hendrix");
		//Initialize the Zend_Paginator
		$paginator = Zend_Paginator::factory($artist);
		$currentPage = 1;
		//Check if the user is not on page 1
		$i = $this->_request->getQuery('i');
		if(!empty($i)){ //Where i is the current page
		$currentPage = $this->_request->getQuery('i');
		}
		//Set the properties for the pagination
		$paginator->setItemCountPerPage(2);
		$paginator->setPageRange(3);
		$paginator->setCurrentPageNumber($currentPage);
		$this->view->paginator = $paginator;*/
	}

    /**
     * Test - Object Oriented Select Statement
     *
     */
    public function testoostatementAction()
    {
		//Create DB object
		require APPLICATION_PATH."/models/Db/Db_Db.php";
		$db = Db_Db::conn();		
		
		
		//Create the statement
		//SELECT `a`.`id`, `a`.`artist_name` AS `name`, `a`.`genre`
		//FROM `artists` AS `a` WHERE (artist_name='Groove Armada')
		
		$select = new Zend_Db_Select($db);
		//Determine which columns to retrieve.
		//Determine which table to retrieve data from.		
		$columns = array("id" => 'id',
						"name" => 'artist_name',
						"genre" => 'genre');
		$tableInfo = array("a" => 'artists');
		$statement = $select->from($tableInfo, $columns)
							->where("artist_name=?", 'Groove Armada')							
							->where('genre=?', 'electronic')
							->orWhere('genre=?', 'house');
		//Query the Database
		$results = $db->query($statement);
		$rows = $results->fetchAll();
		//Compare Statement
		echo $statement->__toString();
		
		
		
		/*2. //Create the statement
		//SELECT `a`.`id` AS `artist id`, `a`.`artist_name` AS `name`,
		//`a`.`genre` FROM `artists` AS `a`
		//Determine which columns to retrieve.
		//Determine which table to retrieve data from.
		$select = new Zend_Db_Select($db);
		$columns = array("artist id" => 'id',
						 "name" => 'artist_name',
						 "genre" => 'genre');
		$tableInfo = array("a" => "artists");
		$statement = $select->from($tableInfo, $columns);
		
		//Query the Database
		$results = $db->query($statement);
		$rows = $results->fetchAll();
		
		//Compare Statement
		echo $statement->__toString();
		
					
		//1. Create the statement
		//SELECT `artists`.`id`, `artists`.`artist_name`, `artists`.`genre`
		//FROM `artists`
		/*$select = new Zend_Db_Select($db);
		//Determine which columns to retrieve.
		$columns = array('id', 'artist_name', 'genre');
		$statement = $select->from('artists', $columns);
		
		//Query the Database
		$results = $db->query($statement);
		$rows = $results->fetchAll();
		//Compare Statement
		echo $statement->__toString();*/

		//Supress the View
		$this->_helper->viewRenderer->setNoRender();
		
    }

    /**
     * Test - Get All Fans
     * 
     *
     */
    public function testoofansAction()
    {
	//Create DB object
	require APPLICATION_PATH."/models/Db/Db_Db.php";
	$db = Db_Db::conn();
	
	
	//2. Create the statement join with order by clause
	//SELECT `a`.`id` AS `artist id`, `a`.`artist_name` AS `name`,
	//`a`.`genre`, `aa`.`account_id` AS `user_id`,
	//`aa`.`created_date` AS `date_became_fan`
	//FROM `artists` AS `a`
	//INNER JOIN `accounts_artists` AS `aa` ON aa.artist_id = a.id
	//ORDER BY `date_became_fan` DESC LIMIT 10
	
	$select = new Zend_Db_Select($db);
	//Determine which columns to retrieve.
	//Determine which table to retrieve data from.
	
	$columns = array("artist id" => 'a.id',
					 "name" => 'a.artist_name',
					 "genre" => 'a.genre');
	$tableInfo = array("a" => 'artists');
	$statement = $select->from($tableInfo, $columns)
						->join(array("aa" => 'accounts_artists'),
							  'aa.artist_id = a.id',
							   array("user_id" => 'aa.account_id',
									 "date_became_fan" =>'aa.created_date'))
						->order("date_became_fan DESC")
						->limit(10);
	$results = $db->query($statement);
	$rows = $results->fetchAll();
	
	//Compare Statement
	echo $statement->__toString();
	
	
	/*1. //Create the statement simple Join
	//SELECT `a`.`id` AS `artist id`, `a`.`artist_name` AS `name`,
	//`a`.`genre`,aa`.`account_id` AS `user_id`,
	//`aa`.`created_date` AS `date_became_fan`
	//FROM `artists` AS `a`
	//INNER JOIN `accounts_artists` AS `aa` ON aa.artist_id = a.id
	$select = new Zend_Db_Select($db);
	//Determine which columns to retrieve.
	//Determine which table to retrieve data from.
	$columns = array("artist id" => 'a.id',
					 "name" => 'a.artist_name',
					 "genre" => 'a.genre');
	$tableInfo = array("a" => 'artists');
	$statement = $select->from($tableInfo, $columns)
						->join(array("aa" => 'accounts_artists'),
									 'aa.artist_id = a.id',array("user_id" => 'aa.account_id',
													             "date_became_fan" =>'aa.created_date'));
	$results = $db->query($statement);
	$rows = $results->fetchAll();
	//Compare Statement
	echo $statement->__toString();*/
	
	
	//Supress the View
	$this->_helper->viewRenderer->setNoRender();
    }

    /**
     * Test – Database expression.
     * 
     *
     */
    public function testoocountAction()
    {
		//Create Db object
		require APPLICATION_PATH."/models/Db/Db_Db.php";
		$db = Db_Db::conn();
		//Create the statement
		// SELECT COUNT(id) AS `total_fans` FROM `accounts_artists` AS `aa`
		$select = new Zend_Db_Select($db);
		//Determine which columns to retrieve.
		//Determine which table to retrieve data from.
		$columns = array("total_fans" =>'COUNT(id)');
		$tableInfo = array("aa" => 'accounts_artists');
		
		$statement = $select->from($tableInfo, $columns);
		$results = $db->query($statement);
		$rows = $results->fetchAll();
		//Compare Statement
		echo $statement->__toString();
		//Supress the View
		$this->_helper->viewRenderer->setNoRender();
    }

    /**
     * Test - Return distinct genres
     * 
     *
     */
    public function testoogenrelistAction()
    {
		//Create Db object
		require APPLICATION_PATH."/models/Db/Db_Db.php";
		$db = Db_Db::conn();
		//Create the statement
		//SELECT DISTINCT `a`.`genre` FROM `artists` AS `a`
		$select = new Zend_Db_Select($db);
		//Determine which columns to retrieve.
		//Determine which table to retrieve data from.
		$columns = array("genre" =>'a.genre');
		$tableInfo = array("a" => 'artists');
		$statement = $select->from($tableInfo, $columns)
							->distinct();
							
		$results = $db->query($statement);
		$rows = $results->fetchAll();
		
		//Compare Statement
		echo $statement->__toString();
		//Supress the View
		$this->_helper->viewRenderer->setNoRender();
    }


}

