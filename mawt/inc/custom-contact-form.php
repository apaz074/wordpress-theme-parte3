<?php
//https://codex.wordpress.org/Class_Reference/wpdb
//https://developer.wordpress.org/reference/classes/wpdb/

if ( !function_exists('mawt_contact_table') ):
  function mawt_contact_table () {
    global $wpdb;
    global $contact_table_version;

    $contact_table_version = '1.0.0';

    $table = $wpdb->prefix . 'contact_form';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "
      CREATE TABLE $table (
        contact_id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        subject VARCHAR(50) NOT NULL,
        comments LONGTEXT NOT NULL,
        contact_date DATETIME NOT NULL,
        PRIMARY KEY (contact_id)
      ) $charset_collate;
    ";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta( $sql );
    add_option( 'contact_table_version', $contact_table_version );
  }
endif;

add_action('after_setup_theme', 'mawt_contact_table');

if ( !function_exists('mawt_contact_form_menu') ):
  function mawt_contact_form_menu () {
    add_menu_page( 'Contacto', 'Contacto', 'administrator', 'contact_form', 'mawt_contact_form_comments', 'dashicons-id-alt', 20 );
    add_submenu_page( 'contact_form', 'Todos los Contactos', 'Todos los Contactos', 'administrator', 'contact_form_comments', 'mawt_contact_form_comments' );
  }
endif;

add_action('admin_menu', 'mawt_contact_form_menu');

if ( !function_exists('mawt_contact_form_comments') ):
  function mawt_contact_form_comments () {
?>
    <div class="wrap">
      <h1><?php _e('Comentarios de la página de Contacto', 'mawt'); ?></h1>
      <table class="wp-list-table widefat striped">
        <thead>
          <tr>
            <th class="manage-column"><?php _e('Id', 'mawt'); ?></th>
            <th class="manage-column"><?php _e('Nombre', 'mawt'); ?></th>
            <th class="manage-column"><?php _e('Email', 'mawt'); ?></th>
            <th class="manage-column"><?php _e('Asunto', 'mawt'); ?></th>
            <th class="manage-column"><?php _e('Comentarios', 'mawt'); ?></th>
            <th class="manage-column"><?php _e('Fecha', 'mawt'); ?></th>
            <th class="manage-column"><?php _e('Eliminar', 'mawt'); ?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Valor 1</td>
            <td>Valor 2</td>
            <td>Valor 3</td>
            <td>Valor 4</td>
            <td>Valor 5</td>
            <td>Valor 6</td>
            <td>Valor 7</td>
          </tr>
        </tbody>
      </table>
    </div>
<?php
  }
endif;

//https://codex.wordpress.org/Shortcode_API
//https://codex.wordpress.org/Function_Reference/add_shortcode
if ( !function_exists('mawt_contact_form') ):
  function mawt_contact_form ( $atts ) {
    echo "
      <div>
        <h1>" . $atts[title]. "</h1>
      </div>
    ";
  }
endif;

add_shortcode( 'contact_form', 'mawt_contact_form' );
?>
