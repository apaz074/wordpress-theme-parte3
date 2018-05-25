# Tema 1: Opciones dinámicas de un tema (Parte 1)

## 1 Opciones dinámicas del tema.

Podemos ver las opciones, tanto de WP como de nuestros plugins en __options.php__ (Ajustes) dentro de nuestro __dashboard__

Nosotros podemos crear nuestras propias opciones dentro de un tema.

Supongamos que firmamos nuestros temas, por ejemplo, __tema creado por autor__ y le damos la posibilidad a nuestro cliente de cambiar ese texto de manera dinámica.

## 2 Crear un menú de ajuste.

Lo primero que tenemos que hacer es crear un menú adicional en nuestro dashboard llamado por ejemplo __ajustes del tema__

Para ello, nos vamos a __functions.php__ y damos de alta un nuevo módulo llamado

`require_once get_template_directory() . '/inc/custom-theme-options.php';
`

Creamos en nuestro __inc__  `custom-theme-options.php`

Agregamos nuestro menú en el dashboard. __Ajustes del Tema__


`add_menu_page( Titulo del tema, Como apareceria en el menu, ¿quien puede ver el menu, variable que se pasa por la URL,función que se ejecuta cuando hacemos click,url del icono,la posicion (va de 5 en 5 hasta el 100) );
`


````php
<?
if ( !function_exists('mawt_custom_theme_options_menu') ):
  function mawt_custom_theme_options_menu () {
    add_menu_page( 'Ajustes del Tema', 'Ajustes del Tema', 'administrator', 'custom_theme_options', 'mawt_custom_theme_options_form', 'dashicons-admin-generic', 20 );
  }
endif;

//Cuando cargue el ménu de administración
add_action('admin_menu', 'mawt_custom_theme_options_menu');

````

Formulario de nuestro menu

`'custom_theme_options'` Es el nombre con el que enlazamos desde nuestro menú del dashboar hasta este formulario `function mawt_custom_theme_options_form ()

````html

if ( !function_exists('mawt_custom_theme_options_form') ):
  function mawt_custom_theme_options_form () {
?>
    <div class="wrap">
      <h1><?php _e('Ajustes y Opciones del Tema', 'mawt'); ?></h1>
      <form action="options.php" method="post">
        <?php
          settings_fields('mawt_options_group');
          do_settings_sections( 'mawt_options_group' );
        ?>
        <table class="form-table">
          <tr valign="top">
            <th scope="row">Texto del Footer:</th>
            <td>
              <input type="text" name="mawt_footer_text" value="<?php echo esc_attr( get_option('mawt_footer_text') ); ?>">
            </td>
          </tr>
        </table>
        <?php submit_button(); ?>
      </form>
    </div>
<?php
  }
endif;
````

## 3 Formulario de menu de ajuste


`<div class="wrap">` Es una clase que usa WP para formatear sus elementos.


Para enviar nuestro formulario usaremos la función de WP ``submit_button();``

```html
<div class="wrap">
      <h1><?php _e('Ajustes y Opciones del Tema', 'mawt'); ?></h1>
      <form action="options.php" method="post">
        <?php
          settings_fields('mawt_options_group');
          do_settings_sections( 'mawt_options_group' );
        ?>
        <table class="form-table">
          <tr valign="top">
            <th scope="row">Texto del Footer:</th>
            <td>
              <input type="text" name="mawt_footer_text" value="<?php echo esc_attr( get_option('mawt_footer_text') ); ?>">
            </td>
          </tr>
        </table>
        <?php submit_button(); ?>
      </form>
    </div>
```

# 4 Registrar opciones de menú en options

Para registrarla en el menú de administración debemos registrarla en este evento `add_action('admin_init', 'mawt_custom_theme_options_register');
`



````php
<?
if ( !function_exists('mawt_custom_theme_options_register') ):
  function mawt_custom_theme_options_register () {
    //un registro por opción
    register_setting('mawt_options_group', 'mawt_footer_text' );
  }
endif;

add_action('admin_init', 'mawt_custom_theme_options_register');
````

En el formulario debemos se deben poner estas opciones. En la primera función le decimos al formulario que ejecute el paquete de opciones
`settings_fields('mawt_options_group');` __mawt_options_group__ y la segunda función sirve para volver a la pagina previa dentro del dashboard `do_settings_sections( 'mawt_options_group' );`

`````html
 <form action="options.php" method="post">
        <?php
          settings_fields('mawt_options_group');
          do_settings_sections( 'mawt_options_group' );
        ?>
        <table class="form-table">
`````

Para que nos imprima el valor que hemos establecido en nuestros "Ajustes del tema" tenemos que escribir en el valor __value__ del campo inpunt tenemos que poner esta función
````html
value="<?php echo esc_attr( get_option('mawt_footer_text') ); ?>">
````

## 5 Imprimir la variable registrada en nuestro tema

````html
        <small>
            <?php
              if ( get_option('mawt_footer_text') !== '' ):
              echo esc_html( get_option( 'mawt_footer_text' ) );
              else:
            ?>
              &copy; <?php echo date('Y'); ?> por @jonmircha
            <?php
              endif;
            ?>
        </small>
````

Nos traemos la opcion que acabamos de crear. Si está vacia ponemos por defecto el texto original. Sino, imprimimos el texto que hemos introducido.

Para ver todas las opciones generales de WP dentro del administrador debemos de meter esta url `http://localhost:8888/mitema/wp-admin/options.php`

## 6 Creando menú de contacto
Enlaces para este apartado

[Interactuar con la BBDD de WP](https://codex.wordpress.org/Class_Reference/wpdb)

[Clases para la BBDD](https://developer.wordpress.org/reference/classes/wpdb/)

## 7 Creando tabla de contacto

Para que tenga los mismo estilos dashboard de WP en la tabla que tenemos que crear

````html
<table class="wp-list-table widefat striped">
````

## 8 Shortcodes

[API shortcode](https://codex.wordpress.org/Shortcode_API)

[Referencia shortcode](https://codex.wordpress.org/Function_Reference/add_shortcode)

`[nombre_shortcode parametro=pasamos el valor]` Así es como invocamos y le pasamos el valor del parámetro a nuestro shortcode.


