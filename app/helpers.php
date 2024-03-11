<?php 
function formatSeasonEpisode($title) {
    // El año es opcional y puede o no estar entre paréntesis
    // Se admite 'capítulo' con o sin tilde y se permite variabilidad en la estructura
    $pattern = '/(?:\(\d{4}\)\s+)?cap[ií]tulo\s+(\d+)\s+temporada\s+(\d+)/i';
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
