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