<?php 


function formatSeasonEpisode($title) {
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





