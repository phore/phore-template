<?php
namespace Phore\Template\Parser\Helper;

class ParserKit
{
    public static function ReadObject(string &$input) : ObjectType {
        $length = strlen($input);
        $insideString = false;
        $escaped = false;
        $wasString = false;
        $stringStartChar = '';
        $objectValue = '';
        for ($i = 0; $i < $length; $i++) {
            $char = $input[$i];
            if ($escaped) {
                $objectValue .= $char;
                $escaped = false;
                continue;
            }
            if ($char === '\\') {
                if ($escaped === true) {
                    $objectValue .= $char;
                    continue;
                }
                $escaped = true;
                continue;
            }
            if (($char === '"' || $char === "'" ) && ! $insideString) {
                $insideString = true;
                $wasString = true;
                $stringStartChar = $char;
                continue;
            }
            if (($char === '"' || $char === "'" ) && $insideString) {
                if ($char === $stringStartChar && ! $escaped) {
                    $insideString = false;
                    break;
                } else {
                    $objectValue .= $char;
                    continue;
                }
            }

            if ($insideString) {
                $objectValue .= $char;
                continue;
            }
        }
        $input = substr($input, $i+1);

        if ($wasString && $insideString)
            throw new \InvalidArgumentException("Unterminated string in input: '$input' in position $i.");

        return new ObjectType(ObjectTypeTypeEnum::STRING, $objectValue);
    }
    public static function ReadUntilToken(string &$input, array $allowedTokens) : string {
        $pos = strcspn($input, implode('', $allowedTokens));
        $result = substr($input, 0, $pos);
        $input = substr($input, $pos);
        return $result;
    }
    public static function ReadToken(string &$input, array $allowedTokens) : string {
        foreach ($allowedTokens as $token) {
            if (strpos($input, $token) === 0) {
                $input = substr($input, strlen($token));
                return $token;
            }
        }
        return '';
    }
    public static function ReadChar(&$input) : ?string {
        $char = $input[0] ?? null;
        $input = substr($input, 1);
        return $char;
    }

    public static function ReadWhitespace(&$input) : ?string {
        $length = strlen($input);
        $whitespace = '';
        for ($i = 0; $i < $length; $i++) {
            if ($input[$i] === ' ') {
                $whitespace .= ' ';
                continue;
            }
            break;
        }
        $input = substr($input, $i);
        return $whitespace;
    }

    public static function IsNextCharAlphabetic(string $input) : bool {
        return preg_match('/[a-zA-Z]/', $input[0]) === 1;
    }

}
