<?php

require_once(dirname(__FILE__).'/Post.php');

class Ploa
{
	// Define procedures
	public $PRO_getPosts = "get_posts";
	public $PRO_getPostByRef = "get_post_by_ref";
	private $dbhost='';
	private $dbuser='';
	private $dbpass='';
	private $dbname='';

	private $dbh=NULL;

	public static $INI=NULL;

	public function __construct($host="", $user="", $pass="", $name="")
	{
		$this->dbSetLogin($host, $user, $pass, $name);

		self::$INI = parse_ini_file(dirname(__FILE__).'/ploa.ini');
	}

	public function dbSetLogin($host, $user, $pass, $name)
	{
		// Store the login credentials
		$this->dbhost = $host;
		$this->dbuser = $user;
		$this->dbpass = $pass;
		$this->dbname = $name;
	}

	public function getPost($ref)
	{
		// Get a connection to the db
		$dbh = $this->dbConnect();
		if($dbh)
		{	
			// Build query with a '?' for each supplied parameter
			$query = 'call '.$this->PRO_getPostByRef.'(?)';
			
			// Create a statment to use the query
			$stmt = $dbh->prepare($query);
	
			// Run the query with the given parameters
			$stmt->execute([$ref]);

			// Return the results
			return $stmt->fetchAll(PDO::FETCH_CLASS,'Post');

		
		}

		// Fail
		return false;
	}

	public function getPosts($offset, $count)
	{
		// Get a connection to the db
		$dbh = $this->dbConnect();
		if($dbh)
		{	
			// Build query with a '?' for each supplied parameter
			$query = 'call '.$this->PRO_getPosts.'(?,?)';
			
			// Create a statment to use the query
			$stmt = $dbh->prepare($query);
	
			// Run the query with the given parameters
			$stmt->execute([$offset,$count]);

			// Return the results
			return $stmt->fetchAll(PDO::FETCH_CLASS,'Post');

		
		}

		// Fail
		return false;
	}

	private function dbConnect()
	{
		// Catch errors to prevent PDO from outputing credentials to page
		try
		{
			// Connect to database using PDO
			$db = new PDO(
				"mysql:host=".$this->dbhost.";".
				"dbname=".$this->dbname.";".
				"charset=utf8",
				$this->dbuser,
				$this->dbpass
			);

			return $db;
		} 
		catch (PDOException $e)
		{
			echo "It broke";
			return false;
		}


	}

	private function dbCall($procedure, $params, $count)
	{
		// Catch errors to prevent PDO from outputing credentials to page
		try
		{
			// Connect to database using PDO
			$db = new PDO(
				"mysql:host=".$this->dbhost.";".
				"dbname=".$this->dbname.";".
				"charset=utf8",
				$this->dbuser,
				$this->dbpass
			);

			// Build query with a '?' for each supplied parameter
			$query = 'call '.$procedure.'(';
			for ( $i = 0; $i < $count;$i++)
			{
				$query .= '?,';
			}
			$query=substr($query,0,strlen($query)-1);
			$query.=')';
			
			// Create a statment to use the query
			$stmt = $db->prepare($query);
	
			// Run the query with the given parameters
			$stmt->execute($params);

			// Return the results
			return $stmt->fetchAll();

		} 
		catch (PDOException $e)
		{
			echo "It broke";
		}
	}

	public function partPostList($offset, $count)
	{
		$dom = new DOMDocument();
		$posts = $this->getPosts($offset, $count);
		$postsDiv = $dom->createElement('div','');
		$dom->appendChild($postsDiv);

		foreach($posts as $post)
		{
			$postsDiv->appendChild($dom->importNode($post->getDOMElement(),true));
		}

		return $dom->documentElement;
	}

	public function partPost($ref)
	{
		$dom = new DOMDocument();
		$post = $this->getPost($ref);
		$postsDiv = $dom->createElement('div','');
		$dom->appendChild($postsDiv);
		$postsDiv->appendChild($dom->importNode($post[0]->getDOMElement(),true));
		
		return $dom->documentElement;
	}




}


?>
