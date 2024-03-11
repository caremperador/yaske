<?php 


function formatSeasonEpisode($title) {
    // Esta expresión regular busca "capítulo" o "capitulo" (con o sin tilde) seguido por un número (el episodio),
    // y luego "temporada" seguida de un número (la temporada), con cualquier cosa antes o después de estos patrones
    $pattern = '/cap[ií]tulo\s+(\d+)\s+temporada\s+(\d+)/i';
    preg_match($pattern, $title, $matches);
    
    if ($matches && count($matches) === 3) {
        // El array $matches debería tener 3 elementos:
        // [0] => string completa
        // [1] => número de capítulo
        // [2] => número de temporada
        return $matches[2] . 'x' . $matches[1];
    } else {
        // Si no se puede determinar el patrón, devuelve el título original o cualquier otro placeholder que desees
        return $title;
    }
}



