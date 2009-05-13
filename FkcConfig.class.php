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
		'friend' => 'http://chingu.prkorea.com/mypage/other_main.jsp',
		'photos' => '',
		'photorepository' => 'http://chingu.prkorea.com/upload/new_board/'
	);

	static $patterns = array (
		'friends' => "|goUserRead\('(.*)'\);\"><img src=\"(.*)\"(.*)><br>(.*)<|U",
		'friendPhoto' => "|<a href=\"javascript:view\('(.*)'\);\"><img src|U",
		'friendProfile' => "|<dl id=\"profile\">(.*)<dt>(.*)<span>(.*)</span></dt>(.*)<dd>(.*)<span>(.*)</span></dd>(.*)<dt>Residential Area </dt>(.*)<dd>(.*), (.*)</dd>(.*)<dt>Job</dt>(.*)<dd>(.*)</dd>(.*)<dt>Interests about  Korea</dt>(.*)<dd>(.*)</dd>(.*)</dl>|U",
		'friendEmail' => "|<dt>Email</dt><dd><a href=\"mailto:(.*)\">(.*)</a></dd>|U",
		'friendAbout' => "|<dt>About Yourself<dt>(.*)<dd>(.*)</dd>|U",
		'friendFavorites' => "|<dl id=\"interests\">(.*)<dt>Favorite Korean Movie</dt>(.*)<dd>(.*)</dd>(.*)<dt>Favorite Korean Entertainer</dt>(.*)<dd>(.*)</dd>(.*)<dt>Favorite Korean Drama</dt>(.*)<dd>(.*)</dd><dt>Favorite Place in Korea</dt>(.*)<dd>(.*)</dd>(.*)<dt>Favorite Korean Food</dt>(.*)<dd>(.*)</dd>(.*)</dl>|U",
		'cookieId' => "|c_sno(.*)\n|U",
		'cookieName' => "|c_first_nm(.*)\n|U",
		'cookieFamilyName' => "|c_family_nm(.*)\n|U",
		'cookieGender' => "|c_gender(.*)\n|U",
		'cookieCountry' => "|c_country(.*)\n|U",
		'cookieResidentialCountry' => "|c_resi_area1(.*)\n|U",
		'cookieResidentialCity' => "|c_resi_area2(.*)\n|U",
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