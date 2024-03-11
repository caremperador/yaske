<?php 


function formatSeasonEpisode($title) {
    // Esta expresión regular busca "capítulo" o "capitulo" (con o sin tilde) seguido por un número (el episodio),
    // y "temporada" seguido por un número (la temporada), independientemente de lo que haya antes o después.
    $pattern = '/cap[ií]tulo\s+(\d+)\s+temporada\s+(\d+)/i';
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




