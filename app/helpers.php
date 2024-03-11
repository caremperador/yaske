<?php 
function formatSeasonEpisode($title) {
    // La expresión regular busca opcionalmente un año en paréntesis, 
    // seguido por 'capítulo' (con o sin tilde), un espacio, 
    // y luego uno o más dígitos que representan el número del capítulo.
    // Después busca la palabra 'temporada', un espacio,
    // y uno o más dígitos que representan el número de la temporada.
    $pattern = '/(?:\(\d{4}\)\s+)?cap[ií]tulo\s+(\d+)\s+temporada\s+(\d+)/i';
    preg_match($pattern, $title, $matches);

    if ($matches && count($matches) === 3) {
        // Se espera que $matches tenga 3 elementos si encuentra coincidencias:
        // [0] => string completa coincidente
        // [1] => número del capítulo
        // [2] => número de la temporada
        return $matches[2] . 'x' . str_pad($matches[1], 2, '0', STR_PAD_LEFT); // Poner ceros a la izquierda para el episodio
    } else {
        // Si no hay coincidencia, devolver el título original o un placeholder
        return $title;
    }
}
