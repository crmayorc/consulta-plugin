<?php
/*
Plugin Name: Consulta Inventario Plugin
Description: Plugin para consultar la tabla de inventario y mostrar los datos con formato de moneda.
Version: 1.0
Author: Cristian Mayor
*/

// Evitar acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

// Función para registrar el menú del plugin en el Dashboard
function cip_agregar_menu() {
    add_menu_page(
        'Consulta Inventario',
        'Consulta Inventario',
        'manage_options',
        'consulta-inventario-plugin',
        'cip_pagina_admin',
        'dashicons-database',
        6
    );
}
add_action('admin_menu', 'cip_agregar_menu');

// Función para renderizar la página de administración del plugin
function cip_pagina_admin() {
    ?>
    <div class="wrap">
        <h1>Consulta de Inventario</h1>
        <button id="cip-consultar" class="button button-primary">Consultar Datos</button>
        <div id="cip-resultados" style="margin-top: 20px;"></div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#cip-consultar').on('click', function() {
            $(this).prop('disabled', true);
            $('#cip-resultados').html('<div class="spinner is-active" style="float: none;"></div>');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'cip_consultar_datos'
                },
                success: function(response) {
                    $('#cip-resultados').html(response);
                },
                complete: function() {
                    $('#cip-consultar').prop('disabled', false);
                }
            });
        });
    });
    </script>
    <?php
}

// Función para formatear moneda
function cip_formato_moneda($valor) {
    return '$ ' . number_format($valor, 2, ',', '.');
}

// Función para formatear fecha
function cip_formato_fecha($fecha) {
    return date('d/m/Y H:i:s', strtotime($fecha));
}

// Función para manejar la consulta AJAX
function cip_consultar_datos() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'productos_inventario';

    $resultados = $wpdb->get_results("
        SELECT 
            codigo,
            talla,
            cantidad,
            precio,
            valor,
            fecha
        FROM $tabla 
        ORDER BY fecha DESC
    ", ARRAY_A);

    if ($resultados) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>';
        echo '<th>Código</th>';
        echo '<th>Talla</th>';
        echo '<th>Cantidad</th>';
        echo '<th>Precio</th>';
        echo '<th>Valor</th>';
        echo '<th>Fecha</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        
        foreach ($resultados as $fila) {
            echo '<tr>';
            echo '<td>' . esc_html($fila['codigo']) . '</td>';
            echo '<td>' . esc_html($fila['talla']) . '</td>';
            echo '<td>' . esc_html($fila['cantidad']) . '</td>';
            echo '<td>' . cip_formato_moneda($fila['precio']) . '</td>';
            echo '<td>' . cip_formato_moneda($fila['valor']) . '</td>';
            echo '<td>' . cip_formato_fecha($fila['fecha']) . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<div class="notice notice-warning"><p>No se encontraron resultados.</p></div>';
    }

    wp_die();
}
add_action('wp_ajax_cip_consultar_datos', 'cip_consultar_datos');

// Función para activación del plugin
function cip_activar() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'productos_inventario';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $tabla (
        codigo INT NOT NULL,
        talla INT NOT NULL,
        cantidad INT NOT NULL,
        precio DECIMAL(10,2) NOT NULL,
        valor DECIMAL(10,2) NOT NULL,
        fecha DATETIME NOT NULL,
        PRIMARY KEY (codigo, talla, fecha)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'cip_activar');
