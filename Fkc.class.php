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

include_once ("FkcUser.class.php");
include_once ("FkcCurl.class.php");
include_once ("FkcConfig.class.php");

class Fkc {

	private $user;
	private $fkcCurl;
	private $login = false;

	function getUser()
	{
		return $this->user;
	}

	function Fkc() {
		// TODO: Check licence
		// if (!licence) || (!function_exists($this->getLicence)) die();
		$this->fkcCurl = new FkcCurl();
		$this->user = new FkcUser(true);
	}

	function login($email, $password) {
		if ($this->login)
			return true;

		// Get session cookie
		$this->fkcCurl->get(FkcConfig :: getUrl('session'));

		// Set login
		$this->user->set('Email',$email);
		$loginHtml = $this->fkcCurl->post(FkcConfig :: getUrl('login'), 'email=' . trim(urlencode($email)) . '&password=' . trim(urlencode($password)));

		// Check valid/invalid user
		if (!strstr($loginHtml, "incorrected ID or password"))
		{
			// Get cookie information
			$fh = fopen(FkcConfig::getCookie(), 'r');
			$cookieInformation = fread($fh, filesize(FkcConfig::getCookie()));
			fclose($fh);
			preg_match_all(FkcConfig::getPattern('cookieId'), $cookieInformation, $cookieIdPattern, PREG_PATTERN_ORDER);
			preg_match_all(FkcConfig::getPattern('cookieName'), $cookieInformation, $cookieNamePattern, PREG_PATTERN_ORDER);
			preg_match_all(FkcConfig::getPattern('cookieFamilyName'), $cookieInformation, $cookieFamilyNamePattern, PREG_PATTERN_ORDER);
			preg_match_all(FkcConfig::getPattern('cookieGender'), $cookieInformation, $cookieGenderPattern, PREG_PATTERN_ORDER);
			preg_match_all(FkcConfig::getPattern('cookieCountry'), $cookieInformation, $cookieCountryPattern, PREG_PATTERN_ORDER);
			preg_match_all(FkcConfig::getPattern('cookieCity'), $cookieInformation, $cookieCityPattern, PREG_PATTERN_ORDER);
			preg_match_all(FkcConfig::getPattern('cookiePhoto'), $cookieInformation, $cookiePhotoPattern, PREG_PATTERN_ORDER);
			$this->user->setId(trim($cookieIdPattern[1][0]));
			$this->user->setName(trim($cookieNamePattern[1][0]));
			$this->user->setFamilyName(trim($cookieFamilyNamePattern[1][0]));
			$this->user->set('Gender',(trim($cookieGenderPattern[1][0]) == "M" ? "male" : "female" ));
			$this->user->set('Country',trim($cookieCountryPattern[1][0]));
			$this->user->set('ResidentialCountry',trim($cookieCityPattern[1][0]));
			$this->user->setPhoto(FkcConfig::getUrl('photorepository') . trim($cookiePhotoPattern[1][0]));

			$this->login = true;
		}
		else
			$this->login = false;

		return $this->login;
	}

	function getFriends() {
		if (!$this->login)
			return false;

		if ($this->user->getFriends() != null)
			return $this->user->getFriends();

		$this->user->setFriends(array ());
		$friendsHtml = $this->fkcCurl->get(FkcConfig :: getUrl('friends'));

		preg_match_all(FkcConfig :: getPattern('friends'), $friendsHtml, $friendsPattern);
		//var_dump($friendsPattern);

		for ($i = 0; $i < count($friendsPattern[1]); $i++) {
			$newFriend = new FkcUser();
			$newFriend->setId((int)utf8_encode(html_entity_decode($friendsPattern[1][$i])));
			$newFriend->setPhoto(utf8_encode(html_entity_decode(FkcConfig :: getUrl('main') . $friendsPattern[2][$i])));
			$newFriend->setFullName(utf8_encode(html_entity_decode($friendsPattern[4][$i])));
			$this->user->addNewFriend($newFriend);
		}

		return $this->user->getFriends();
	}

	function getHtmlLicence()
	{
		return "<p>Friendly Korea Community API.<br />Created by Miguel &Aacute;ngel Dom&iacute;nguez Coloma (<a href=\"mailto:eridem@gmail.com\">eridem@gmail.com</a>)<br /><a href=\"http://eridem.net/friendly-korea-community-api/\">http://eridem.net/friendly-korea-community-api/</a><br />Licenced by GPL v3.</p>";
	}
}
?>