<?php

class View
{
    function generate($content_view, $template_view, $data = null)
    {
        $html_data = '';
        /*
        if(is_array($data)) {
            // преобразуем элементы массива в переменные
            extract($data);
        }
        */

        include "views/$template_view";
        return $html_data;
    }
}