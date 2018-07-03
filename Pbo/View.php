<?php
namespace Pbo;

class View
{
    public static function render($template = '', $vars)
    {
        $template = VIEWS_DIR . $template . '.php';
        if(!file_exists($template)) die("View {$template} tidak ditemukan!");
        if(is_array($vars)) extract($vars);
        ob_start();
        require($template);
        return ob_get_clean();
    }
}
