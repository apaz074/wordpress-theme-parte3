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

 
