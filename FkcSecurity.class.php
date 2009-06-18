<?php

class FkcSecurity
{
	static function HtmlInjection($text)
	{
		$text = utf8_encode(html_entity_decode(trim($text)));
		$text = htmlspecialchars($text);

		// Just parse simple <br>
		$text = preg_replace("|&lt;br(.*)&gt;|U", "<br${1}>", $text);
		return $text;
	}
}

?>
