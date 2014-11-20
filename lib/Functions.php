<?php

namespace Stools;

/**
 * Returns pretty formatted JSON encoded data.
 * 
 * @param array $json
 * @return string
 */
function pretty_json ($json) {
	
	if (PHP_VERSION_ID >= 50400) {
		
		$result = json_encode ($json, JSON_PRETTY_PRINT);
	} else {

		$result = '';
		$pos = 0;
		$strLen = strlen ($json);
		$indentStr = '  ';
		$newLine = "\n";
		$prevChar = '';
		$outOfQuotes = true;

		for ($i = 0; $i <= $strLen; $i ++ ) {

			// Grab the next character in the string.
			$char = substr ($json, $i, 1);

			// Are we inside a quoted string?
			if ($char == '"' && $prevChar != '\\') {
				$outOfQuotes = ! $outOfQuotes;

				// If this character is the end of an element, 
				// output a new line and indent the next line.
			} else if (($char == '}' || $char == ']') && $outOfQuotes) {
				$result .= $newLine;
				$pos --;
				for ($j = 0; $j < $pos; $j ++ ) {
					$result .= $indentStr;
				}
			}

			// Add the character to the result string.
			$result .= $char;

			// If the last character was the beginning of an element, 
			// output a new line and indent the next line.
			if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
				$result .= $newLine;
				if ($char == '{' || $char == '[') {
					$pos ++;
				}

				for ($j = 0; $j < $pos; $j ++ ) {
					$result .= $indentStr;
				}
			}

			$prevChar = $char;
		}
	}
	return $result;
}

/**
 * Sanitizes data for serialize.
 * 
 * @param string $phpdata
 * @return boolean
 */
function sanitize_phpdata ($phpdata) {

	$return = true;
	if (($tokens = token_get_all ($phpdata))) {
		foreach ($tokens as $token) {
			if (is_array ($token)) {
				switch ($token[0]) {
					case T_ARRAY:
					case T_CHARACTER:
					case T_DNUMBER:
					case T_INLINE_HTML:
					case T_LNUMBER:
					case T_STRING_VARNAME:
						break;
					default:
						$return = false;
				}
			}
		}
	}
	return $return;
}