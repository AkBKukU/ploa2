<?php

class Post
{
	private $id_post;
	private $post_ref;
	private $timestamp;
	private $datetime_posted;
	private $post_data;
	private $title;
	private $published;

	private $dom;
	private $article;

	public function __construct()
	{
		$this->buildDOM();
	}	

	private function buildDOM()
	{
		$this->dom = new DOMDocument();
		$this->article = $this->dom->createElement("article","");
		$header = $this->dom->createElement("header","");
		$this->article->appendChild($header);
		
		$linkHeader = $this->dom->createElement("a");
		$header->appendChild($linkHeader);
		$linkHeader->setAttribute('href',Ploa::$INI['PLOA_POST_VIEW_URI'].$this->post_ref);
		$mainHeader = $this->dom->createElement("h2",$this->title);
		$linkHeader->appendChild($mainHeader);
		$subHeader = $this->dom->createElement("h3",$this->datetime_posted);
		$header->appendChild($subHeader);
		$body = $this->dom->createElement("div","");
		$this->article->appendChild($body);
		$frag = $this->dom->createDocumentFragment();
		$frag->appendXML($this->post_data);
		$body->appendChild($frag);
	}

	public function getDOMElement()
	{
		return $this->article;
	}

}

?>
