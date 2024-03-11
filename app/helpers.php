<?php 


function formatSeasonEpisode($title) {
    // Esta expresión regular busca "capítulo" o "capitulo" (con o sin tilde) seguido de un número (el episodio),
    // y luego "temporada" seguido de un número (la temporada), independientemente de lo que venga antes o después en el título.
    $pattern = '/cap[ií]tulo\s+(\d+)\s+temporada\s+(\d+)/i';
    preg_match($pattern, $title, $matches);
    
    if ($matches && count($matches) === 3) {
        // El array $matches debería tener 3 elementos:
        // [0] => string completa
        // [1] => número de capítulo
        // [2] => número de temporada
        return 'S' . $matches[2] . 'E' . $matches[1]; // Formato S{temporada}E{episodio}
    } else {
        // Si no se puede determinar el patrón, devuelve el título original o cualquier otro placeholder que desees
        return $title;
    }
}


