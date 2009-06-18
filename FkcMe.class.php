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

class FkcMe extends FkcUser {

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
		'friends' => '',
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

	private $isGuestbookInformationGet = false;
	private $attGuestbook = array(
		'guestbook' => array());

	private $isPhotosInformationGet = false;
	private $attPhotos = array(
		'photos' => array());

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
		else if (array_key_exists($key, $this->attGuestbook))
		{
			$this->getGuestbookPageInformation($force);
			return $this->attGuestbook[$key];
		}
		else if (array_key_exists($key, $this->attPhotos))
		{
			$this->getPhotoPageInformation($force);
			return $this->attPhotos[$key];
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
		else if (array_key_exists($key, $this->attGuestbook))
		{
			$this->attGuestbook[$key] = $value;
		}
		else if (array_key_exists($key, $this->attPhotos))
		{
			$this->attPhotos[$key] = $value;
		}
	}

	protected function getCookieInformation($force = false)
	{
		if ($this->isCookieInformationGet && !$force)
			return;

		parent::getCookieInformation();

		$this->attCookie['id'] = $this->atts['id'];
		$this->attCookie['email'] = $this->atts['email'];
		$this->attCookie['name'] = $this->atts['name'];
		$this->attCookie['familyname'] = $this->atts['familyname'];
		$this->attCookie['gender'] = $this->atts['gender'];
		$this->attCookie['country'] = $this->atts['country'];
		$this->attCookie['residentialcountry'] = $this->atts['residentialcountry'];
		$this->attCookie['residentialcity'] = $this->atts['residentialcity'];
		$this->attCookie['photo'] = $this->atts['photo'];

		// Do not enter in this method again
		$this->isCookieInformationGet = true;
	}

	protected function getProfilePageInformation($force = false)
	{
		if ($this->isProfilePageInformationGet && !$force)
			return;

		parent::getProfilePageInformation(FkcConfig :: getUrl('profile'));

		$this->attProfile['friends'] = $this->atts['friends'];
		$this->attProfile['gender'] = $this->atts['gender'];
		$this->attProfile['borndate'] = $this->atts['borndate'];
		$this->attProfile['country'] = $this->atts['country'];
		$this->attProfile['residentialcountry'] = $this->atts['residentialcountry'];
		$this->attProfile['residentialcity'] = $this->atts['residentialcity'];
		$this->attProfile['profession'] = $this->atts['profession'];
		$this->attProfile['interests'] = $this->atts['interests'];
		$this->attProfile['about'] = $this->atts['about'];
		$this->attProfile['favoritemovie'] = $this->atts['favoritemovie'];
		$this->attProfile['favoriteentertainent'] = $this->atts['favoriteentertainent'];
		$this->attProfile['favoritedrama'] = $this->atts['favoritedrama'];
		$this->attProfile['favoriteplace'] = $this->atts['favoriteplace'];
		$this->attProfile['favoritefood'] = $this->atts['favoritefood'];

		// Do not enter in this method again
		$this->isProfilePageInformationGet = true;
	}

	protected function getPhotoPageInformation($force = false)
	{
		if ($this->isPhotoPageInformationGet && !$force)
			return;

		parent::getPhotoPageInformation(FkcConfig :: getUrl('photos'));

		$this->attPhotos['photos'] = $this->atts['photos'];

		// Do not enter in this method again
		$this->isPhotoPageInformationGet = true;
	}

	protected function getGuestbookPageInformation($force = false)
	{
		if ($this->isGuestbookPageInformationGet && !$force)
			return;

		parent::getGuestbookPageInformation(FkcConfig :: getUrl('guestbook'));

		$this->attGuestbook['guestbook'] = $this->atts['guestbook'];

		// Do not enter in this method again
		$this->isGuestbookPageInformationGet = true;
	}
}
?>