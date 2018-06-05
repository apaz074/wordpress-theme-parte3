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

## Visualizar los datos recogidos por el formulario en nuestro Dashboard

Recogemos los datos de la tabla de la BBDD 
````php
<? 
global $wpdb;
    //prefix es wp_ el prefijo de WP en la BBDD
   $table = $wpdb->prefix . 'contact_form';
   //Nos creamos filas para traernos los datos.
   $rows = $wpdb->get_results( "SELECT * FROM $table", ARRAY_A );
````

Por medio de la función `get_results(Sentecia SQL, Arreglo asociativo)`
Se aconseja usar __var_dump()__ para ver el valor de las variables

`  // echo '<pre>';
  //   var_dump($rows);
  // echo '</pre>';
`
Vamos a implementar la función de eliminar para ello HTML 5 trae los campos data y nos vamos a valer de ellos para saber que registro queremos eliminar

`data-contact-id="<?php echo $row['contact_id']; ?>`

```html
<a href="#" class="u-delete" data-contact-id="<?php echo $row['contact_id']; ?>">
                  Eliminar
                </a>
```

````php
<?

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
          <?php
            global $wpdb;
            $table = $wpdb->prefix . 'contact_form';
            $rows = $wpdb->get_results( "SELECT * FROM $table", ARRAY_A );
              // echo '<pre>';
              //   var_dump($rows);
              // echo '</pre>';
              foreach ( $rows as $row ):
          ?>
            <tr>
              <td><?php echo $row['contact_id']; ?></td>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['subject']; ?></td>
              <td><?php echo $row['comments']; ?></td>
              <td><?php echo $row['contact_date']; ?></td>
              <td>
                <a href="#" class="u-delete" data-contact-id="<?php echo $row['contact_id']; ?>">
                  Eliminar
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
<?php
  }
endif;
````

## Dandole funcionalidad AJAX


Vamos a registrar el scripts para la parte de administración.

Observamos que registramos los archivos JS no en el frontend sino en la parte de administración 

`wp_register_script( 'contact-form-admin-script', get_template_directory_uri() . '/js/contact_form_admin.js', array('jquery'), '1.0.0', true );` contact-form-__admin__-scrip.

Esta función es __superpoderosa__ pues nos permite pasar valores de WP a JS 

__admin-ajax.php__ Es creado para las interacciones entre el front y el backend. Necesitamos pasarle esa URL para trabajar con ajax ya que vamos a usar esa ruta `'ajax_url' => admin_url('admin-ajax.php')`.



````php
<?
 //Permita pasar valores de PHP a JS en notación de Objeto
    wp_localize_script(
      'contact-form-admin-script',
      'contact_form',
      array(
        'name' => 'Módulo de Comentarios de Contacto',
        'ajax_url' => admin_url('admin-ajax.php')
      )
    );
````


````php
<?
if ( !function_exists( 'mawt_contact_admin_scripts' ) ):
  function mawt_contact_admin_scripts () {
    wp_register_script( 'contact-form-admin-script', get_template_directory_uri() . '/js/contact_form_admin.js', array('jquery'), '1.0.0', true );

    wp_enqueue_script( 'contact-form-admin-script' );

    //Permita pasar valores de PHP a JS en notación de Objeto
    wp_localize_script(
      'contact-form-admin-script',
      'contact_form',
      array(
        'name' => 'Módulo de Comentarios de Contacto',
        'ajax_url' => admin_url('admin-ajax.php')
      )
    );
  }
endif;

add_action('admin_enqueue_scripts', 'mawt_contact_admin_scripts');
````

Script que debemos incluir para darle una funcionalidad ajax a la hora de eliminar los registros de contacto.
Lo primero es registrar el formulario `c(contact_form)`

WP usa el Ajax de Jquery en la parte administrativa.

````javascript
c(contact_form)

  d.addEventListener('click', e => {
    if (e.target.matches('.u-delete')) {
      e.preventDefault()
      //c(e.target.dataset.contactId)

      let id = e.target.dataset.contactId,
        confirmDelete = confirm(`¿Estas seguro de eliminar el comentario con el ID ${id}?`)

      if (confirmDelete) {
        $.ajax({
          type: 'post',
          data: {
            'id': id,
            'action': 'mawt_contact_form_delete'
          },
          url: contact_form.ajax_url,
          success: data => {
            c(data)
            let res = JSON.parse(data)
            if (!res.err) {
              let selectorId = '[data-contact-id="' + id + '"]'
              c(selectorId)
              d.querySelector(selectorId).parentElement.parentElement.remove()
            }
          }
        })
      } else {
        return false;
      }
    }
  })
})(document, console.log, jQuery.noConflict());
````
## Progamando el evento del botón eliminar

Vamos a delegar eventos para que cuando el objeto que origino el evento sea el que nosotros quedamos.

`d.addEventListener('click', e => {...}` Evento click de todo el documento.

Vamos a validarlo solo cual se active el selector que nosotros queramos y lo hacemos mediante una sentencia if `if (e.target.matches('.u-delete')` __u-delete__ es un selector válido css y podemos definir cualquiera.

Esta sentencia encapsula el identificador en un contendor dataset `let id = e.target.dataset.contactId,` y guardamos el __id__ en una variable local. Además creamos una alerta de confirmación para estar seguros si queremos seguir adelante.

````javascript
 let id = e.target.dataset.contactId,
 confirmDelete = confirm(`¿Estas seguro de eliminar el comentario con el ID ${id}?`)
 //${id} Template string
````

Llamamos el método Ajax de jquery y la petición la solicitamos por POST

`````javascript
if (confirmDelete) {
        $.ajax({
          type: 'post',
          data: {
            'id': id,
            'action': 'mawt_contact_form_delete'
          },
          url: contact_form.ajax_url,
          success: data => {
            c(data)
            let res = JSON.parse(data)
            if (!res.err) {
              let selectorId = '[data-contact-id="' + id + '"]'
              c(selectorId)
              d.querySelector(selectorId).parentElement.parentElement.remove()
            }
          }
        });
`````
Mandamos los datos con el id y la acción a ejecutar

````javascript
data: {
             'id': id,
             'action': 'mawt_contact_form_delete'
           }
```


Destino de la acción ajax `url: contact_form.ajax_url` 

Si la operación tuvo exito 

````javascript
data: {
             'id': id,
             'action': 'mawt_contact_form_delete'
           }
````` 

Escribimos ahora la función PHP que va a llevar a cabo la operación solicitada por ajax. Los datos va a ser solicitados por POST `if ( isset($_POST['id']) ):`

````php
<?
if ( !function_exists('mawt_contact_form_delete') ):
  function mawt_contact_form_delete () {
    if ( isset($_POST['id']) ):
      global $wpdb;

      $table = $wpdb->prefix . 'contact_form';
      //Guardamos la ejecucción  y pasamos la tabla de donde se va a eliminar contenida en la variable $table, el campo de donde vamos a eliminar y el valor identificatibo.
      //array('%d') validación y mascara de mysql
      $delete_row = $wpdb->delete($table, array( 'contact_id' => $_POST['id'] ), array('%d'));

      //Si no hubo error (y tubo exito) entramos en este if
      if ( $delete_row ) {
        //Creamos la variable respuesta que es un arreglo con error a false y comentario concatenado con el id de POST
          $response = array(
          'err' => false,
          'msg' => 'Se elimino el comentario con el ID ' . $_POST['id']
        );
          //En caso contrario err es verdadero con mensaje coherente
      } else {
        $response = array(
          'err' => true,
          'msg' => 'NO se elimino el comentario con el ID ' . $_POST['id']
        );
      }

      //Cuando trabajomos con peticiones AJAX tenemos que usar el método die(...)
      //como es objeto la decodificamos como Json y JS lo entienda como un objeto de JS
      die( json_encode($response) );
    endif;
  }
endif;
````

##Detalles finales del botón eliminar

` let res = JSON.parse(data)` Le decimos que codifique este string a un objeto de javascript

`if (!res.err)` si la propiedad es falsa vamos a eliminar el enlace

` let selectorId = '[data-contact-id="' + id + '"]'` Dinamicamente vamos a registar su ID para seleccionarlo con el atributo ID

Para eliminar toda la fila le pasamos el abuelo __selectorId__ y eliminamos todos los descendientes __.parentElement.parentElement.remove()__

````javascript
 success: data => {
            c(data)
            
            let res = JSON.parse(data)
            if (!res.err) {
              let selectorId = '[data-contact-id="' + id + '"]'
              c(selectorId)
              d.querySelector(selectorId).parentElement.parentElement.remove()
            }
          }
        })
````