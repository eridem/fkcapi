<?php

class FkcPhoto
{
	private $text = '';
	private $date = '';
	private $photoUrl = '';
	private $userId = 0;

	public function getText()
	{
		return $this->text;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getPhotoUrl()
	{
		return $this->photoUrl;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function __construct($text, $date, $photoUrl, $userId)
	{
		$this->text = $text;
		$this->date = $date;
		$this->photoUrl = $photoUrl;
		$this->userId = $userId;
	}
}

?>
