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

	private $isCookieInformationGet = false;
	private $attCookie = array(
		'id' => '',
		'name' => '',
		'familyname' => '',
		'email' => '',
		'photo' => '',
		'gender' => '',
		'country' => '',
		'residentialcountry' => '',
		'residentialcity' => '',
	);

	private $isProfilePageInformationGet = false;
	private $attProfile = array(
		'borndate' => '',
		'description' => '',
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

	function FkcUser() {
	}

	/**
	 * Attribute methods
	 */
	function get($key, $force = false)
	{
		$key = strtolower(trim($key));

		if (array_key_exists($key, $this->attCookie))
		{
			$this->getCookieInformation($force);
			return $this->attCookie[$key];
		}
		else if (array_key_exists($key, $this->attProfile))
		{
			$this->getProfilePageInformation($force);
			return $this->attProfile[$key];
		}
		else if (array_key_exists($key, $this->attFriends))
		{
			$this->getFriendsInformation($force);
			return $this->attFriends[$key];
		}

		return "";
	}

	function set($key, $value)
	{
		$key = strtolower(trim($key));
		if (array_key_exists($key, $this->attProfile))
		{
			$this->attProfile[$key] = $value;
		}
		else if (array_key_exists($key, $this->attCookie))
		{
			$this->attCookies[$key] = $value;
		}
		else if (array_key_exists($key, $this->attFriends))
		{
			$this->attFriends[$key] = $value;
		}
	}

	private function getCookieInformation($force = false)
	{
		if ($this->isCookieInformationGet && !$force)
			return;

		$fh = fopen(FkcConfig::getCookie(), 'r');
		$cookieInformation = fread($fh, filesize(FkcConfig::getCookie()));
		fclose($fh);
		preg_match_all(FkcConfig::getPattern('cookieId'), $cookieInformation, $cookieIdPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieName'), $cookieInformation, $cookieNamePattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieFamilyName'), $cookieInformation, $cookieFamilyNamePattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieGender'), $cookieInformation, $cookieGenderPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieCountry'), $cookieInformation, $cookieCountryPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieResidentialCountry'), $cookieInformation, $cookieResidentialCountryPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieResidentialCity'), $cookieInformation, $cookieResidentialCityPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookiePhoto'), $cookieInformation, $cookiePhotoPattern, PREG_PATTERN_ORDER);
		$this->attCookie['id'] = trim($cookieIdPattern[1][0]);
		$this->attCookie['name'] = trim($cookieNamePattern[1][0]);
		$this->attCookie['familyname'] = trim($cookieFamilyNamePattern[1][0]);
		$this->attCookie['gender'] = (trim($cookieGenderPattern[1][0]) == "M" ? "male" : "female" );
		$this->attCookie['country'] = trim($cookieCountryPattern[1][0]);
		$this->attCookie['residentialcountry'] = trim($cookieResidentialCountryPattern[1][0]);
		$this->attCookie['residentialcity'] = trim($cookieResidentialCityPattern[1][0]);
		$this->attCookie['photo'] = FkcConfig::getUrl('photorepository') . trim($cookiePhotoPattern[1][0]);

		// Do not enter in this method again
		$this->isCookieInformationGet = true;
	}

	private function getFriendsInformation($force = false)
	{
		if ($this->isFriendsPageInformationGet && !$force)
			return;

		$curl = new FkcCurl();
		$this->attFriends["friends"] = array();
		$friendsHtml = $curl->get(FkcConfig :: getUrl('friends'));

		preg_match_all(FkcConfig :: getPattern('friends'), $friendsHtml, $friendsPattern);

		for ($i = 0; $i < count($friendsPattern[1]); $i++) {
			$newFriend = new FkcFriend();
			$newFriend->set('id', ((int)utf8_encode(html_entity_decode($friendsPattern[1][$i]))));
			$newFriend->set('photo', (utf8_encode(html_entity_decode(FkcConfig :: getUrl('main') . $friendsPattern[2][$i]))));

			$fullNames = split(' ', utf8_encode(html_entity_decode($friendsPattern[4][$i])));
			$newFriend->set('name', $fullNames[0]);
			$familyName = "";
			for ($j = 1; $j < count($fullNames); $j++)
			{
				$familyName .= $fullNames[1] . " ";
			}
			$newFriend->set('familyName', trim($familyName));

			$this->attFriends["friends"][] = $newFriend;
		}

		// Do not enter in this method again
		$this->isFriendsPageInformationGet = true;
	}
}
?>