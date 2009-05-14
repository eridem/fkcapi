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
include_once ("FkcMe.class.php");
include_once ("FkcFriend.class.php");
include_once ("FkcCurl.class.php");
include_once ("FkcConfig.class.php");
include_once ("FkcSecurity.class.php");

class Fkc {

	private $user;
	private $fkcCurl;
	private $login = false;

	function getUser()
	{
		return $this->user;
	}

	function Fkc() {
		$this->fkcCurl = new FkcCurl();
		$this->user = new FkcMe();
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
			$this->login = true;
		else
			$this->login = false;

		return $this->login;
	}

	function getHtmlLicence()
	{
		return "<p>Friendly Korea Community API.<br />Created by Miguel &Aacute;ngel Dom&iacute;nguez Coloma (<a href=\"mailto:eridem@gmail.com\">eridem@gmail.com</a>)<br /><a href=\"http://eridem.net/friendly-korea-community-api/\">http://eridem.net/friendly-korea-community-api/</a><br />Licenced by GPL v3.</p>";
	}
}
?>