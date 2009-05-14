<?php

class FkcSecurity
{
	static function HtmlInjection($text)
	{
		$text = utf8_encode(html_entity_decode(trim($text)));
		$text = htmlspecialchars($text);
		return $text;
	}
}

?>
