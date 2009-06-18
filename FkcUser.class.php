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

abstract class FkcUser {

	protected $atts = array();

	/**
	 * Attribute methods
	 */
	function get($key, $force = false){}

	function set($key, $value){}

	protected function getCookieInformation()
	{
		$fh = fopen(FkcConfig::getCookie(), 'r');
		$cookieInformation = fread($fh, filesize(FkcConfig::getCookie()));
		fclose($fh);
		preg_match_all(FkcConfig::getPattern('cookieId'), $cookieInformation, $cookieIdPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieEmail'), $cookieInformation, $cookieEmailPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieName'), $cookieInformation, $cookieNamePattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieFamilyName'), $cookieInformation, $cookieFamilyNamePattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieGender'), $cookieInformation, $cookieGenderPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieCountry'), $cookieInformation, $cookieCountryPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieResidentialCountry'), $cookieInformation, $cookieResidentialCountryPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookieResidentialCity'), $cookieInformation, $cookieResidentialCityPattern, PREG_PATTERN_ORDER);
		preg_match_all(FkcConfig::getPattern('cookiePhoto'), $cookieInformation, $cookiePhotoPattern, PREG_PATTERN_ORDER);
		$this->atts['id'] = trim($cookieIdPattern[1][0]);
		$this->atts['email'] = trim($cookieEmailPattern[1][0]);
		$this->atts['name'] = trim($cookieNamePattern[1][0]);
		$this->atts['familyname'] = trim($cookieFamilyNamePattern[1][0]);
		$this->atts['gender'] = (trim($cookieGenderPattern[1][0]) == "M" ? "male" : "female" );
		$this->atts['country'] = trim($cookieCountryPattern[1][0]);
		$this->atts['residentialcountry'] = trim($cookieResidentialCountryPattern[1][0]);
		$this->atts['residentialcity'] = trim($cookieResidentialCityPattern[1][0]);
		$this->atts['photo'] = FkcConfig::getUrl('photorepository') . trim($cookiePhotoPattern[1][0]);
	}

	protected function getProfilePageInformation($url)
	{
		$curl = new FkcCurl();
		$this->atts['friends'] = array();
		$mainPageHtml = str_replace(array("\n", "\r", "\t"),'',$curl->get($url));

		/**
		 * Friends Pattern
		 * - Create a friend
		 * - Add basic information
		 */
		preg_match_all(FkcConfig :: getPattern('friends'), $mainPageHtml, $friendsPattern);
		for ($i = 0; $i < count($friendsPattern[1]); $i++) {
			// Photo
			$photo = FkcSecurity::HtmlInjection($friendsPattern[2][$i]);
			if ($photo == FkcConfig :: getPhotoBlank())
				$photo = FkcConfig :: getNoPhoto();
			$photo = FkcConfig :: getUrl('main') . $photo;

			// Name and family name
			$fullNames = split(' ', FkcSecurity:: HtmlInjection($friendsPattern[4][$i]));
			$familyName = "";
			for ($j = 1; $j < count($fullNames); $j++)
				$familyName .= $fullNames[$j] . " ";

			// Adding a friend
			$newFriend = new FkcFriend();
			$newFriend->set('id', (int)FkcSecurity:: HtmlInjection($friendsPattern[1][$i]));
			$newFriend->set('photo', $photo);
			$newFriend->set('name', $fullNames[0]);
			$newFriend->set('familyName', trim($familyName));
			$this->atts['friends'][] = $newFriend;
		}

		// Profile Pattern
		preg_match_all(FkcConfig :: getPattern('friendEmail'), $mainPageHtml, $emailPattern);
		if ($emailPattern[2][0] != "")
			$this->atts['email'] = FkcSecurity:: HtmlInjection($emailPattern[2][0]);

		// Profile Pattern
		preg_match_all(FkcConfig :: getPattern('friendProfile'), $mainPageHtml, $profilePattern);
		$this->atts['gender'] = FkcSecurity:: HtmlInjection(str_replace(array("(", ")"), '', $profilePattern[3][0]));
		$this->atts['borndate'] = FkcSecurity:: HtmlInjection($profilePattern[5][0]);
		$this->atts['country'] = FkcSecurity:: HtmlInjection(str_replace(array("|"), '', $profilePattern[6][0]));
		$this->atts['residentialcountry'] = FkcSecurity:: HtmlInjection($profilePattern[9][0]);
		$this->atts['residentialcity'] = FkcSecurity:: HtmlInjection($profilePattern[10][0]);
		$this->atts['profession'] = FkcSecurity:: HtmlInjection($profilePattern[13][0]);
		$this->atts['interests'] = FkcSecurity:: HtmlInjection($profilePattern[16][0]);

		// About Pattern
		preg_match_all(FkcConfig :: getPattern('friendAbout'), $mainPageHtml, $aboutPattern);
		$this->atts['about'] = FkcSecurity:: HtmlInjection($aboutPattern[2][0]);

		// Favorites Pattern
		preg_match_all(FkcConfig :: getPattern('friendFavorites'), $mainPageHtml, $favoritesPattern);

		$this->atts['favoritemovie'] = FkcSecurity:: HtmlInjection($favoritesPattern[3][0]);
		$this->atts['favoriteentertainent'] = FkcSecurity:: HtmlInjection($favoritesPattern[6][0]);
		$this->atts['favoritedrama'] = FkcSecurity:: HtmlInjection($favoritesPattern[9][0]);
		$this->atts['favoriteplace'] = FkcSecurity:: HtmlInjection($favoritesPattern[11][0]);
		$this->atts['favoritefood'] = FkcSecurity:: HtmlInjection($favoritesPattern[14][0]);
	}

	protected function getPhotoPageInformation($url, $id = '')
	{
		$curl = new FkcCurl();
		$this->atts['photos'] = array();
		if ($id == '')
			$photosPageHtml = str_replace(array("\n", "\r", "\t"), '', $curl->get($url));
		else
		{
			$post = "";
			$photosPageHtml = "TODO";
		}

		// Message Pattern
		preg_match_all(FkcConfig :: getPattern('friendPhotos'), $photosPageHtml, $photoPattern);

		for ($i = 0; $i < count($photoPattern[1]); $i++)
		{
			$text = ''; // TODO
			$date = FkcSecurity:: HtmlInjection($photoPattern[6][$i]);
			$photoUrl = FkcConfig :: getUrl('main') . FkcSecurity:: HtmlInjection($photoPattern[2][$i]);
			$user = $id;
			$photo = new FkcPhoto($text, $date, $photoUrl, $user);
			$this->atts['photos'][] = $photo;
		}
	}

	protected function getGuestbookPageInformation($url, $id = '', $email = '', $name = '')
	{
		$curl = new FkcCurl();
		$this->atts['guestbook'] = array();
		if ($id == '')
			$guestbookPageHtml = str_replace(array("\n", "\r", "\t"),'',$curl->get($url));
		else
		{
			$post = "owner_sno=".$id."&pageno=1";
			$guestbookPageHtml = str_replace(array("\n", "\r", "\t"),'',$curl->post($url, $post));
		}

		// Message Pattern
		preg_match_all(FkcConfig :: getPattern('friendGuestbook'), $guestbookPageHtml, $messagePattern);

		for ($i = 0; $i < count($messagePattern[1]); $i++) {
			$m_user = FkcSecurity:: HtmlInjection($messagePattern[2][$i]);
			$m_date = FkcSecurity:: HtmlInjection($messagePattern[5][$i]);
			$m_text = FkcSecurity:: HtmlInjection($messagePattern[7][$i]);
			$message = new FkcGuestbookMessage($m_text, $m_date, $m_user);
			$this->atts['guestbook'][] = $message;
		}

		// Number Pages Pattern
		preg_match_all(FkcConfig :: getPattern('friendGuestbookPages'), $guestbookPageHtml, $pageNoPattern);
		for ($j = 0; $j < count($pageNoPattern[1]); $j++)
		{
			if ($id == '')
				$post = "pageno=" . $pageNoPattern[1][$j];
			else
			{
				$post = "owner_sno=".$id."&pageno=".$pageNoPattern[1][$j];
				$guestbookPageHtml = str_replace(array("\n", "\r", "\t"),'',$curl->post($url, $post));
			}

			$guestbookPageHtml = str_replace(array("\n", "\r", "\t"),'',$curl->post($url, $post));
			// Message Pattern
			preg_match_all(FkcConfig :: getPattern('friendGuestbook'), $guestbookPageHtml, $messagePattern);

			for ($i = 0; $i < count($messagePattern[1]); $i++) {
				$m_user = FkcSecurity:: HtmlInjection($messagePattern[2][$i]);
				$m_date = FkcSecurity:: HtmlInjection($messagePattern[5][$i]);
				$m_text = FkcSecurity:: HtmlInjection($messagePattern[7][$i]);
				$message = new FkcGuestbookMessage($m_text, $m_date, $m_user);
				$this->atts['guestbook'][] = $message;
			}
		}
	}
}
?>