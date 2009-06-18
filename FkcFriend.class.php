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

class FkcFriend extends FkcUser{

	private $isBasicInformationGet = false;
	private $attBasic = array(
		'id' => '',
		'name' => '',
		'familyname' => '',
		'photo' => ''
	);

	private $isProfilePageInformationGet = false;
	private $attProfile = array(
		'friends' => '',
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

	private $idGuestbookInformationGet = false;
	private $attGuestbook = array(
		'guestbook' => array());

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
		else if (array_key_exists($key, $this->attGuestbook))
		{
			$this->getGuestbookPageInformation($force);
			return $this->attGuestbook[$key];
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
		else if (array_key_exists($key, $this->attGuestbook))
		{
			$this->attGuestbook[$key] = $value;
		}
	}

	protected function getBasicInformation($force = false)
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

	protected function getProfilePageInformation($force = false)
	{
		if ($this->isProfilePageInformationGet && !$force)
			return;

		parent::getProfilePageInformation(FkcConfig :: getUrl('friend') . "?sno=" . $this->attBasic['id']);

		$this->attProfile['email'] = $this->atts['email'];
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
		$this->isBasicInformationGet = true;
	}

	protected function getGuestbookPageInformation($force = false)
	{
		if ($this->isGuestbookPageInformationGet && !$force)
			return;

		parent::getGuestbookPageInformation(FkcConfig :: getUrl('friendguestbook'), $this->get('id'), $this->get('email'), $this->get('name') + " "+ $this->get('familyname'));

		$this->attGuestbook['guestbook'] = $this->atts['guestbook'];

		// Do not enter in this method again
		$this->isGuestbookPageInformationGet = true;
	}
}
?>