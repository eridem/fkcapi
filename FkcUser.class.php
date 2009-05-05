<?php
/**
    This file is part of Friendly Korea Community API.

    Foobar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Friendly Korea Community API is distributed in the hope that it will
    be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
    of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Friendly Korea Community API.
    If not, see <http://www.gnu.org/licenses/>.

    Miguel Ángel Domínguez Coloma (eridem@gmail.com)
    http://eridem.net/friendly-korea-community-api/
*/

class FkcUser {

	private $isInformationGet = false;

	private $id;
	private $fullname;
	private $name;
	private $familyName;
	private $photo;

	private $attFriendPage = array(
		'gender' => '',
		'email' => '',
		'borndate' => '',
		'description' => '',
		'country' => '',
		'residentialcountry' => '',
		'residentialcity' => '',
		'profession' => '',
		'interests' => '',
		'about' => '',
		'favoritemovie' => '',
		'favoriteentertainent' => '',
		'favoritedrama' => '',
		'favoriteplace' => '',
		'favoritefood' => ''
	);

	private $friends = array();

	function FkcUser($mainUser = false) {
		$this->isInformationGet = $mainUser;
	}

	function setId($value)
	{
		if (is_int($value))
			$this->id = $value;
	}

	function getId()
	{
		return $this->id;
	}

	/**
	 * Attribute methods
	 */
	function get($key)
	{
		$key = strtolower(trim($key));
		if (array_key_exists($key, $this->attFriendPage))
		{
			$this->getMainPageInformation();
			return $this->attFriendPage[$key];
		}

		return "";
	}

	function set($key, $value)
	{
		$key = strtolower(trim($key));
		if (array_key_exists($key, $this->attFriendPage))
		{
			$this->attFriendPage[$key] = $value;
		}
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
		$this->getMainPageInformation();
		return $this->familyName;
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

	private function getMainPageInformation()
	{
		if ($this->isInformationGet)
			return;

		$curl = new FkcCurl();
		$mainPageHtml = $curl->post(FkcConfig :: getUrl('friend'), 'sno='.$this->id);
		$mainPageHtml = str_replace(array("\n", "\r", "\t"),'',$mainPageHtml);

		// Friend Profile Pattern
		preg_match_all(FkcConfig :: getPattern('friendProfile'), $mainPageHtml, $profilePattern);
		$this->set('Gender', str_replace(array("(", ")"), '', $profilePattern[3][0]));
		$this->set('BornDate', trim($profilePattern[5][0]));
		$this->set('Country', trim(str_replace(array("|"), '', $profilePattern[6][0])));
		$this->set('ResidentialCountry', trim($profilePattern[9][0]));
		$this->set('ResidentialCity', trim($profilePattern[10][0]));
		$this->set('Profession', trim($profilePattern[13][0]));
		$this->set('Interests', trim($profilePattern[16][0]));

		// Friend Email Pattern
		preg_match_all(FkcConfig :: getPattern('friendEmail'), $profilePattern[7][0], $emailPattern);
		$this->set('email', trim($emailPattern[1][0]));

		// Friend About Pattern
		preg_match_all(FkcConfig :: getPattern('friendAbout'), $mainPageHtml, $aboutPattern);
		$this->set('about', trim($aboutPattern[2][0]));

		// Friend Favorites Pattern
		preg_match_all(FkcConfig :: getPattern('friendFavorites'), $mainPageHtml, $favoritesPattern);
		$this->set('favoriteMovie', trim($favoritesPattern[3][0]));
		$this->set('favoriteEntertainent', trim($favoritesPattern[6][0]));
		$this->set('favoriteDrama', trim($favoritesPattern[9][0]));
		$this->set('favoritePlace', trim($favoritesPattern[11][0]));
		$this->set('favoriteFood', trim($favoritesPattern[14][0]));

		// Do not enter in this method again
		$this->isInformationGet = true;
	}
}
?>