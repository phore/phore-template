<?php

/**
 * Parse Arguements from a string including escaped characters and string enclosures
 *
 * @param string $arguments     The string to parse
 * @param string $separator     The character that separates the arguments
 * @param string $breakChar     The character that will break the parsing and return the rest of the string
 * @param string $rest          The rest of the string after the last argument
 *
 *
 * @throws \Exception
 */
function phore_parse_arguments(string $arguments, string $separator = ' ', string $breakChar = "|", string &$rest=""): array
{
    $args = [];
    $length = strlen($arguments);
    $insideString = false;
    $escaped = false;
    $argName = '';
    $argValue = '';
    $expectArgValue = false;
    $stringStartChar = '';

    for ($i = 0; $i < $length; $i++) {
        $char = $arguments[$i];



        // Handle escaped characters
        if ($escaped) {
            $argValue .= $char;
            $escaped = false;
            continue;
        }
        if ($char === '\\') {
            $escaped = true;
            continue;
        }

        // Manage string enclosure
        if ($char === '"' || $char === "'") {
            if ($insideString) {
                if ($char === $stringStartChar) {
                    $insideString = false;
                    $expectArgValue = false;
                    continue;
                } else {
                    $argValue .= $char; // For cases like "abc\"def"
                    continue;
                }
            } else {
                $insideString = true;
                $stringStartChar = $char;
                continue;
            }
        }

        if ($insideString) {
            $argValue .= $char;
            continue;
        }

        // Handle the end of argument names or values
        if ($char === '=' && !$insideString) {
            $expectArgValue = true;
            $argName = trim($argName);
            $argValue = '';
            continue;
        }

        if ($char === " " || $char === "\t") {
            // Ignore whitespace outside character strings
            continue;
        }



        // Handle separators and end of argument processing
        if (($char === $separator || $char === ',') && !$insideString) {
            if ($argName !== '') {
                $args[$argName] = is_numeric($argValue) ? (float)$argValue : (strtolower($argValue) === "true" ? true : (strtolower($argValue) === "false" ? false : trim($argValue, "\'\"")));
                $argName = '';
                $argValue = '';
            }
            continue;
        }

        // Handle break character
        if ($char === $breakChar && !$insideString) {
            $rest = substr($arguments, $i+1);
            break;
        }

        // Building argument names or values
        if (!$expectArgValue) {
            $argName .= $char;
        } else {
            $argValue .= $char;
        }
    }

    // Handle the last argument if any
    if ($argName !== '') {
        $args[$argName] = is_numeric($argValue) ? (float)$argValue : (strtolower($argValue) === "true" ? true : (strtolower($argValue) === "false" ? false : trim($argValue, "\'\"")));
    }

    // Error checking for unclosed strings or illegal characters
    if ($insideString) {
        throw new \Exception("String not closed. Error at position: " . $i);
    }

    return $args;
}

