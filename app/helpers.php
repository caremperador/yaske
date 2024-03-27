<?php


function formatSeasonEpisode($title)
{
    // Utilizamos el modificador 'u' para tratar la expresión regular como UTF-8
    // y hacemos que detecte tanto "capítulo" como "capitulo" (con y sin tilde)
    $pattern = '/cap[ií]tulo\s+(\d+)\s+temporada\s+(\d+)/iu';
    preg_match($pattern, $title, $matches);

    if ($matches && count($matches) === 3) {
        // [0] => string completa
        // [1] => número de capítulo
        // [2] => número de temporada
        return $matches[2] . 'x' . $matches[1];
    } else {
        // Si no se puede determinar el patrón, devuelve el título original o cualquier otro placeholder que desees
        return $title;
    }
}


function extractTitleName($title) {
    // Esta expresión regular busca cualquier texto antes de un espacio seguido de un año (con o sin paréntesis)
    $pattern = '/^(.*?)(?:\s*\(\d{4}\)|\s+\d{4})/';
    preg_match($pattern, $title, $matches);
    
    if ($matches && count($matches) > 1) {
        // [0] => string completa
        // [1] => nombre de la serie o película antes del año
        return trim($matches[1]);
    } else {
        // Si no se encuentra el patrón, devuelve el título original o cualquier otro placeholder que desees.
        // Esto puede ser útil para títulos que no siguen el formato esperado.
        return $title;
    }
}

function spanishTitle($video) {
    // Asegura que se acceda correctamente a las propiedades del objeto
    if (isset($video->es_titulo) && !empty($video->es_titulo)) {
        return $video->es_titulo;
    }
    else if (isset($video->lat_titulo) && !empty($video->lat_titulo)) {
        return $video->lat_titulo;
    }
    else {
        return $video->titulo;
    }
}

