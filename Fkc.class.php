<?php
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
		$this->user = new FkcUser();
	}

	function login($email, $password) {
		if ($this->login)
			return true;

		// Get session cookie
		$this->fkcCurl->get(FkcConfig :: getUrl('session'));

		// Set login
		$this->user->setEmail($email);
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
			$this->user->setGender(trim($cookieGenderPattern[1][0]));
			$this->user->setCountry(trim($cookieCountryPattern[1][0]));
			$this->user->setCity(trim($cookieCityPattern[1][0]));
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

		preg_match_all(FkcConfig :: getPattern('friends'), $friendsHtml, $friendsPattern, PREG_PATTERN_ORDER);
		for ($i = 0; $i < count($friendsPattern[1]); $i++) {
			$newFriend = new FkcUser();
			$newFriend->setPhoto(utf8_encode(html_entity_decode(FkcConfig :: getUrl('main') . $friendsPattern[1][$i])));
			$newFriend->setFullName(utf8_encode(html_entity_decode($friendsPattern[2][$i])));
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