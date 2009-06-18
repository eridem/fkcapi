<?php

class FkcGuestbookMessage
{
	private $text = '';
	private $date = '';
	private $userId = 0;

	public function getText()
	{
		return $this->text;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function __construct($text, $date, $userId)
	{
		$this->text = $text;
		$this->date = $date;
		$this->userId = $userId;
	}
}

?>
