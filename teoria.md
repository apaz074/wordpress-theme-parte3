# Creando estructura de formulario de contacto

## Registrar opciones de menú en options.

Vamos a crear nuestro módulo __en inc__ llamado __custom-conttact-form.php__ Debemos de recordar que estos módulos forman parte de nuestro functions.php pero que lo dividimos en diferentes arhivos php dentro de inc para simplificar y tener más ordenado el código.

Nuestro formulario se va a enviar mediante el método `method="POST"`.
__( $atts )__ es el atributo que recibe desde el dashboard mediante y que indicamos en el shortcode.




````php
<?
if ( !function_exists('mawt_contact_form') ):
  function mawt_contact_form ( $atts ) {
?>
    <form class="ContactForm" method="POST">
     <legend><?php echo $atts['title']; ?></legend>
     <input type="text" name="name" placeholder="Escribe tu nombre">
     <input type="email" name="email" placeholder="Escribe tu email">
     <input type="text" name="subject" placeholder="Asunto a tratar">
      <textarea name="comments" cols="50" rows="5" placeholder="Escribe tus comentarios"></textarea>
      <input type="submit" value="Enviar">
      <input type="hidden" name="send_contact_form" value="1">
    </form>
<?php
  }
endif;


add_shortcode( 'contact_form', 'mawt_contact_form' );

```` 
## Registrando CSS y JS del formulario de contacto.

En la carpeta CSS de nuestro tema, vamos a crear un archivo llamado __contact_form.css__. 
En la carpeta JS vamos a crear los archivos __contact_form.js__ y __contact_form_admin.js__.
Ahora vamos a registrar nuestros archivos JS y CSS.

__Creamos un condicional tag porque solo queremos que nuestros css y js se carguen cuando vayamos a nuestra página de contacto__. 
Preguntamos si estamos en la página de contacto `if ( is_page('contacto') ):`

No se va a cargar Jquery `'/js/contact_form.js', array(No hace falta Jquery),`

```php
<?
if ( !function_exists( 'mawt_contact_scripts' ) ):
  function mawt_contact_scripts () {
    if ( is_page('contacto') ):
      wp_register_style( 'contact-form-style', get_template_directory_uri() . '/css/contact_form.css', array(), '1.0.0', 'all' );
      wp_enqueue_style( 'contact-form-style' );

      wp_register_script( 'contact-form-script', get_template_directory_uri() . '/js/contact_form.js', array(), '1.0.0', true );

      wp_enqueue_script( 'contact-form-script' );
    endif;
  }
endif;

add_action('wp_enqueue_scripts', 'mawt_contact_scripts');
```

 
## Envío y validación de la información del formulario.

Debemos de encontrar una manera que nos diga si el formulario se envio. Para estos casos el campo oculto es muy útil. `      <input type="hidden" name="send_contact_form" value="1">`
Ahora vamos a crear una función que __guarde el formulario__.

Añadiremos la función nada más se cargue nuestro tema `add_action('init', 'mawt_contact_form_save');
`
Recuperamos el método __POST__ para recuperar la información de la variable y usamos la función __isset__ recuperando la variable __'send_contact_form'__ para determinar si el formulario se ha enviado.
`   if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['send_contact_form'] ) ):`

Si ambas condiciones se cumplen __ejecutamos las funciones para trabajar con la base de datos__ Si por ejemplo recuperamos las variables directamente de POST como por ejemplo `$name = $_POST['name']...etc` __corremos el riesgo de que los usuarios nos inyecten código HTML__.

Para evitarlo WP nos provee de algunas funciones para tratar este tipo de datos de manera más segura `sanitize_text_field($_POST['name']);`. La función __sanitize_text_field(...)__ evita la inyección de código.

`$table = $wpdb->prefix . 'contact_form';`.

Operaciones con la BBDD de WP

```php
<?
    $table = $wpdb->prefix . 'contact_form';
     $form_data = array (
       'name' => $name,
       'email' => $email,
       'subject' => $subject,
       'comments' => $comments,
       'contact_date' => date('Y-m-d H:m:s')
     );
     //Arreglo posicional %s significa que lo que está esperando la BBDD es un string
     $form_formats = array ( '%s', '%s', '%s', '%s', '%s' );
     $wpdb->insert($table, $form_data, $form_formats);
 ```


```php
<?
if ( !function_exists( 'mawt_contact_form_save' ) ):
  function mawt_contact_form_save () {
   if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['send_contact_form'] ) ):

    //invocamos la variable global de WP.  Hay que invoarla aunque sea global.
    global $wpdb;

    $name = sanitize_text_field( $_POST['name'] );
    $email = sanitize_text_field( $_POST['email'] );
    $subject = sanitize_text_field( $_POST['subject'] );
    $comments = sanitize_text_field( $_POST['comments'] );

    $table = $wpdb->prefix . 'contact_form';

    $form_data = array (
      'name' => $name,
      'email' => $email,
      'subject' => $subject,
      'comments' => $comments,
      'contact_date' => date('Y-m-d H:m:s')
    );

    $form_formats = array ( '%s', '%s', '%s', '%s', '%s' );

    $wpdb->insert($table, $form_data, $form_formats);

    $url = get_page_by_title( 'Gracias por tus comentarios' );
    wp_redirect( get_permalink( $url->ID ) );
    exit();
   endif;
  }
endif;

add_action('init', 'mawt_contact_form_save');

````
## Redireccionar nuestro formulario y solucionar error 404

Todo el sistema de plantillas de WP se hace por GET y nosotros estamos mandando nuestro formulario por POST. Por lo tanto, cuando enviamos el formulario WP nos da un error 404.
Para solucionarlo podemos crear una página tipo __gracias por tus comentarios__ y redireccionar el formulario hacia nuestra página. 
Una vez creada la página de agradecimiento podemos redirigir nuestro formulario, después de insertar los datos en la BBDD que vaya hacia nuestra página de agradecimiento.
Para poder identificar la url correctamente creamos la variable `$url` y la rellenamos con nuestra página de agradecimiento ` $url = get_page_by_title( 'gracias' );`que obtenemos mediante el nombre que le hemos dado.
Luego usamos la función de WP __wp_redirect()__ y le pasamos los parámetros necesarios `wp_redirect( get_permalink( $url->ID ));` 
__exit()__ es para que no procese nada más.
