<?php
class FkcUser {

	private $id;
	private $fullname;
	private $name;
	private $familyName;
	private $gender;
	private $email;
	private $bornDate;
	private $description;
	private $city;
	private $country;
	private $photo;

	private $friends = null;
	private $messages = null;
	private $photos = null;

	function FkcUser() {
	}

	function setId($value)
	{
		if (is_int($value))
			$this->id = $value;
	}

	/**
	 * Attribute methods
	 */

	function getId()
	{
		return $this->id;
	}

	function setFullName($value)
	{
		$this->fullname = $value;
	}

	function getFullName()
	{
		return $this->fullname;
	}

	function setName($value)
	{
		$this->name = $value;
	}

	function getName()
	{
		return $this->name;
	}

	function setFamilyName($value)
	{
		$this->familyName = $value;
	}

	function getFamilyName()
	{
		return $this->familyName;
	}

	function setGender($value)
	{
		if (($value == "M") || ($value == "W"))
			$this->gender = $value;
	}

	function getGender()
	{
		return $this->gender;
	}

	function setEmail($value)
	{
		// TODO: Check email
		$this->email = $value;
	}

	function getEmail()
	{
		return $this->email;
	}

	function setBornDate($value) {
		// TODO: Check date
		$this->bornDate = $value;
	}

	function getBornDate()
	{
		return $this->bornDate;
	}

	function setDescription($value)
	{
		$this->description = $value;
	}

	function getDescription()
	{
		return $this->description;
	}

	function setCity($value)
	{
		$this->city = $value;
	}
	function getCity()
	{
		return $this->city;
	}

	function setCountry($value)
	{
		$this->country = $value;
	}

	function getCountry()
	{
		return $this->country;
	}

	function setPhoto($value) {
		$this->photo = $value;
	}

	function getPhoto(){
		return $this->photo;
	}

	function setFriends($value)
	{
		if (is_array($value))
			$this->friends = $value;
	}

	function getFriends()
	{
		return $this->friends;
	}

	/**
	 * Add a new friend.
	 */
	function addNewFriend($friend)
	{
		$this->friends[] = $friend;
	}
}
?>