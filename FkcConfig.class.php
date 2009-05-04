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

class FkcConfig {
	static $debug = true;
	static $cookiefile = '/tmp/fkc_cookie';

	static $urls = array (
		'main' => 'http://chingu.prkorea.com/',
		'session' => 'http://chingu.prkorea.com/member/login.jsp',
		'login' => 'http://chingu.prkorea.com/member/login_m.jsp',
		'logout' => '',
		'friends' => 'http://chingu.prkorea.com/mypage/friends.jsp',
		'photos' => '',
		'photorepository' => 'http://chingu.prkorea.com/upload/new_board/'
	);

	static $patterns = array (
		'friends' => "|<img src=\"(.*)\" width=\"80\" height=\"60\"  onmouseover=\"this.className='on'\" onmouseout=\"this.className='off'\"><br>(.*)</a></li>|U",
		'cookieId' => "|c_sno(.*)\n|U",
		'cookieName' => "|c_first_nm(.*)\n|U",
		'cookieFamilyName' => "|c_family_nm(.*)\n|U",
		'cookieGender' => "|c_gender(.*)\n|U",
		'cookieCountry' => "|c_country(.*)\n|U",
		'cookieCity' => "|c_resi_area1(.*)\n|U",
		'cookiePhoto' => "|c_photo(.*)\n|U"
	);

	static function getUrl($url) {
		if (!empty ($url) && array_key_exists($url, self :: $urls))
			return self :: $urls[$url];
		else
			return self :: $urls['main'];
	}

	static function getPattern($pattern) {
		if (!empty ($pattern) && array_key_exists($pattern, self :: $patterns))
			return self :: $patterns[$pattern];
		else
			return "";
	}

	static function getCookie()
	{
		return self :: $cookiefile;
	}
}
?>