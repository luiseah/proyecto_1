<?php
function p_add_register_shortcode() {
    $archivo_contenido =  __DIR__ . '/template.html';

    return file_exists($archivo_contenido)
        ? file_get_contents($archivo_contenido)
        : 'El archivo de contenido no existe.';
}

add_shortcode( 'shortcode_message', 'p_add_register_shortcode');