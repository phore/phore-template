<?php

use Phore\Template\PhoreTemplate;


function phore_template(string $templateString, array $data = []) : PhoreTemplate
{
    return new PhoreTemplate(templateString: $templateString, data: $data);
}

function phore_template_file(string $filename, array $data = []) : PhoreTemplate
{
    return new PhoreTemplate(templateFile: $filename, data: $data);
}

require_once __DIR__ . "/parse_arguments.php";
