<?php
namespace App\Controllers;

 abstract class Controller
{
    public function render(string $folder, array $data = [], $template = 'default')
    {
        extract($data);

        ob_start();

        require_once ROOT.'/Views/'.$folder.'.php';

        $content = ob_get_clean();

        require_once ROOT.'/Views/'.$this->$template.'.php';
    }
}

