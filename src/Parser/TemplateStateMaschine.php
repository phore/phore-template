<?php

namespace Phore\Template;

class TemplateStateMaschine
{

    private $currentState = "content";
    private string $tagName = "";
    private $tagOptions = [];

    private function parseTag(string $tag)
    {

        if ( ! preg_match("/^(\w+)(.*)$/", $tag, $matches)) {
            throw new \InvalidArgumentException("Invalid tag name: " . $this->tagName);
        }

        return ["name" => $matches[1], "args" => $matches[2]];

    }


    public function injectTag(array $contentBuffer, $tag, int $lineNo) {


        $tag = $this->parseTag($tag);

        if ($this->currentState == "content") {
            $this->currentState = "tag";
            $this->tagBuffer[] = $tag;
            if ($tag["name"] == "ifdef") {
                $this->tagName = "ifdef";
                return;
            }

            throw new \InvalidArgumentException("Invalid tag: " . $tag["name"] . " in line " . $lineNo);
        }

        if ($this->currentState == "tag") {
            if ($tag["name"] == "endif") {
                if ($this->tagName != "ifdef")
                    throw new \InvalidArgumentException("endif without matching if in line " . $lineNo);
                $this->currentState = "content";
                $this->tagName = "";
                return;
            }
            $this->tagBuffer[] = $tag;
            return;
        }
    }


}
