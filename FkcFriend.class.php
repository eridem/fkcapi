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

class FkcFriend {

	private $isBasicInformationGet = false;
	private $attBasic = array(
		'id' => '',
		'name' => '',
		'familyname' => '',
		'photo' => ''
	);

	private $isProfilePageInformationGet = false;
	private $attProfile = array(
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

	private $isFriendsPageInformationGet = false;
	private $attFriends = array('friends' => '');

	function FkcUser($mainUser = false) {
		$this->isInformationGet = $mainUser;
		$this->isMainUser = $mainUser;
	}

	/**
	 * Attribute methods
	 */
	function get($key, $force = false)
	{
		$key = strtolower(trim($key));

		if (array_key_exists($key, $this->attBasic))
		{
			$this->getBasicInformation($force);
			return $this->attBasic[$key];
		}
		else if (array_key_exists($key, $this->attProfile))
		{
			$this->getProfilePageInformation($force);
			return $this->attProfile[$key];
		}
		else if (array_key_exists($key, $this->attFriends))
		{
			$this->getFriendsPageInformation($force);
			return $this->attFriends[$key];
		}

		return "";
	}

	function set($key, $value)
	{
		$key = strtolower(trim($key));
		if (array_key_exists($key, $this->attBasic))
		{
			$this->attBasic[$key] = $value;
		}
		else if (array_key_exists($key, $this->attProfile))
		{
			$this->attProfile[$key] = $value;
		}
		else if (array_key_exists($key, $this->attFriends))
		{
			$this->attFriends[$key] = $value;
		}
	}

	private function getBasicInformation($force = false)
	{
		$isNeedGetBasic = false;
		foreach ($this->attBasic as $key=>$value)
		{
			$isNeedGetBasic = $isNeedGetBasic || ($value == '');
		}

		if ($isNeedGetBasic && $this->attBasic['id'] != '')
		{
			$this->getProfilePageInformation();
			return;
		}

		if (!$isNeedGetBasic)
			$this->isBasicInformationGet = true;

		if ($this->isBasicInformationGet && !$force)
		{
			return;
		}

		if ($this->attBasic['id'] != '')
		{
			$this->getProfilePageInformation();
		}
	}

	private function getProfilePageInformation($force = false)
	{
		if ($this->isFriendsPageInformationGet && !$force)
			return;

		$curl = new FkcCurl();
		$mainPageHtml = $curl->post(FkcConfig :: getUrl('friend'), 'sno='.$this->attBasic['id']);
		$mainPageHtml = str_replace(array("\n", "\r", "\t"),'',$mainPageHtml);

		// Friend Photo Pattern
		preg_match_all(FkcConfig :: getPattern('friendPhoto'), $mainPageHtml, $photoPattern);
		$photo = trim($photoPattern[2][0]);
		$this->attBasic['photo'] = FkcConfig :: getUrl('main') . ($photo == "" ? FkcConfig :: getNoPhoto() : $photo);

		// Friend Profile Pattern
		preg_match_all(FkcConfig :: getPattern('friendProfile'), $mainPageHtml, $profilePattern);
		$fullNames = split(' ', trim($profilePattern[2][0]));
		$familyName = "";
		for ($j = 1; $j < count($fullNames); $j++)
		{
			$familyName .= $fullNames[1] . " ";
		}
		$this->attBasic['name'] = $fullNames[0];
		$this->attBasic['familyname'] = trim($familyName);
		$this->attProfile['gender'] = str_replace(array("(", ")"), '', $profilePattern[3][0]);
		$this->attProfile['borndate'] = trim($profilePattern[5][0]);
		$this->attProfile['country'] = trim(str_replace(array("|"), '', $profilePattern[6][0]));
		$this->attProfile['residentialcountry'] = trim($profilePattern[9][0]);
		$this->attProfile['residentialcity'] = trim($profilePattern[10][0]);
		$this->attProfile['profession'] = trim($profilePattern[13][0]);
		$this->attProfile['interests'] = trim($profilePattern[16][0]);

		// Friend Email Pattern
		preg_match_all(FkcConfig :: getPattern('friendEmail'), $profilePattern[7][0], $emailPattern);
		$this->attProfile['email'] = trim($emailPattern[1][0]);

		// Friend About Pattern
		preg_match_all(FkcConfig :: getPattern('friendAbout'), $mainPageHtml, $aboutPattern);
		$this->attProfile['about'] = trim($aboutPattern[2][0]);

		// Friend Favorites Pattern
		preg_match_all(FkcConfig :: getPattern('friendFavorites'), $mainPageHtml, $favoritesPattern);
		$this->attProfile['favoritemovie'] = trim($favoritesPattern[3][0]);
		$this->attProfile['favoriteentertainent'] = trim($favoritesPattern[6][0]);
		$this->attProfile['favoritedrama'] = trim($favoritesPattern[9][0]);
		$this->attProfile['favoriteplace'] = trim($favoritesPattern[11][0]);
		$this->attProfile['favoritefood'] = trim($favoritesPattern[14][0]);

		// Do not enter in this method again
		$this->isBasicInformationGet = true;
		$this->isFriendsPageInformationGet = true;
	}
}
?>