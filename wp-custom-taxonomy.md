# Taxonomía Personalizada

* [Custom Post Types](#custom-post-types)
* [Custom Taxonomies](#custom-taxonomies)
* [Custom Fields](#custom-fields)
* [Metaboxes](#metaboxes)

## Custom Post Types

Un post es cada uno de los contenidos que WordPress puede guardar.

Los post predeterminados son:

* Entradas (post)
* Páginas (page)
* Archivos adjuntos (attachment)
* Revisiones (revision)
* Menús (nav_menu_item)

Los custom pos types pueden actuar como entradas o páginas y se pueden organizar en categorías, etiquetas o taxonomías.

###  Entradas vs Páginas

Entradas | Páginas
-- | --
Orden cronológico | Es sólo un elemento
No tienen padres o hijos | Puede tener padre o hijos
Tiene categorías | No tiene categorías
Tiene etiquetas | No tiene etiquetas

### Más info

* [Developers WordPress](https://developer.wordpress.org/themes/basics/post-types/)
* [Codex WordPress](https://codex.wordpress.org/Post_Types)
* [Generate WP](https://generatewp.com/post-type/)
* [Custom Post Type UI](https://es.wordpress.org/plugins/custom-post-type-ui/)

```php
function custom_post_type() {
  $labels = array(
    'name' => _x( 'Post Types', 'Post Type General Name', 'mawt' ),
    'singular_name' => _x( 'Post Type', 'Post Type Singular Name', 'mawt' ),
    'menu_name' => __( 'Post Types', 'mawt' ),
    'name_admin_bar' => __( 'Post Type', 'mawt' ),
    'archives' => __( 'Item Archives', 'mawt' ),
    'attributes' => __( 'Item Attributes', 'mawt' ),
    'parent_item_colon' => __( 'Parent Item:', 'mawt' ),
    'all_items' => __( 'All Items', 'mawt' ),
    'add_new_item' => __( 'Add New Item', 'mawt' ),
    'add_new' => __( 'Add New', 'mawt' ),
    'new_item' => __( 'New Item', 'mawt' ),
    'edit_item' => __( 'Edit Item', 'mawt' ),
    'update_item' => __( 'Update Item', 'mawt' ),
    'view_item' => __( 'View Item', 'mawt' ),
    'view_items' => __( 'View Items', 'mawt' ),
    'search_items' => __( 'Search Item', 'mawt' ),
    'not_found' => __( 'Not found', 'mawt' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'mawt' ),
    'featured_image' => __( 'Featured Image', 'mawt' ),
    'set_featured_image' => __( 'Set featured image', 'mawt' ),
    'remove_featured_image' => __( 'Remove featured image', 'mawt' ),
    'use_featured_image' => __( 'Use as featured image', 'mawt' ),
    'insert_into_item' => __( 'Insert into item', 'mawt' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'mawt' ),
    'items_list' => __( 'Items list', 'mawt' ),
    'items_list_navigation' => __( 'Items list navigation', 'mawt' ),
    'filter_items_list' => __( 'Filter items list', 'mawt' ),
  );

  $args = array(
    'label' => __( 'Post Type', 'mawt' ),
    'description' => __( 'Post Type Description', 'mawt' ),
    'labels' => $labels,
    // las taxonomías que soportará
    'taxonomies' => array( 'category', 'post_tag' ),
    // Todo lo que soporta este post type
		'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
		//hierarchical true se comporta como página, false como entrada
		'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    //El icono que tendrá https://developer.wordpress.org/resource/dashicons
    'menu_icon' => 'dashicons-welcome-view-site',
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'page',
  );

  register_post_type( 'a_post_type', $args );
}

add_action( 'init', 'custom_post_type', 0 );
```

**[⬆ regresar al índice](#taxonomía-personalizada)**

## Custom Taxonomies

Las taxonomías son la forma de agrupar contenido en WordPress, permiten relacionar contenido mediante términos en común.

Las taxonomías predeterminadas son:

* Categorías (category)
* Etiquetas (tag)

Las custom taxonomies pueden actuar como categorías o etiquetas.

###  Categorías vs Etiquetas

Categorías | Etiquetas
-- | --
Son obligatorias, toda entrada tiene al menos una | Son opcionales
Son jerárquicas (padres o hijos) | No son jerárquicas
Primer método para agrupar contenido en WordPress | Segundo método para agrupar contenido en WordPress

### Más info

* [Developers WordPress](https://developer.wordpress.org/themes/basics/categories-tags-custom-taxonomies/)
* [Codex WordPress](https://codex.wordpress.org/Taxonomies)
* [Generate WP](https://generatewp.com/taxonomy/)
* [Custom Post Type UI](https://es.wordpress.org/plugins/custom-post-type-ui/)

```php
function custom_taxonomy() {
  $labels = array(
    'name' => _x( 'Taxonomies', 'Taxonomy General Name', 'mawt' ),
    'singular_name' => _x( 'Taxonomy', 'Taxonomy Singular Name', 'mawt' ),
    'menu_name' => __( 'Taxonomy', 'mawt' ),
    'all_items' => __( 'All Items', 'mawt' ),
    'parent_item' => __( 'Parent Item', 'mawt' ),
    'parent_item_colon' => __( 'Parent Item:', 'mawt' ),
    'new_item_name' => __( 'New Item Name', 'mawt' ),
    'add_new_item' => __( 'Add New Item', 'mawt' ),
    'edit_item' => __( 'Edit Item', 'mawt' ),
    'update_item' => __( 'Update Item', 'mawt' ),
    'view_item' => __( 'View Item', 'mawt' ),
    'separate_items_with_commas' => __( 'Separate items with commas', 'mawt' ),
    'add_or_remove_items' => __( 'Add or remove items', 'mawt' ),
    'choose_from_most_used' => __( 'Choose from the most used', 'mawt' ),
    'popular_items' => __( 'Popular Items', 'mawt' ),
    'search_items' => __( 'Search Items', 'mawt' ),
    'not_found' => __( 'Not Found', 'mawt' ),
    'no_terms' => __( 'No items', 'mawt' ),
    'items_list' => __( 'Items list', 'mawt' ),
    'items_list_navigation' => __( 'Items list navigation', 'mawt' ),
  );

  $args = array(
    'labels' => $labels,
    //hierarchical true se comporta como categoría, false como etiqueta
    'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_tagcloud' => true,
  );
  register_taxonomy( 'a_taxonomy', array( 'a_post_type' ), $args );
}

add_action( 'init', 'custom_taxonomy', 0 );
```

**[⬆ regresar al índice](#taxonomía-personalizada)**

## Custom Fields

Los campos personalizados pueden utilizarse para añadir metadatos extra a un post, son nativos de WordPress.

Los metadatos se manejan en pares de clave/valor (Key/Value). La clave es el nombre del metadato, mientras que el valor es la información que aparecerá en la lista de metadatos de cada entrada individual a la que la información esté asociada.

### Más info

* [Codex WordPress](https://codex.wordpress.org/es:Using_Custom_Fields)
* [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/)
* [CMB2](https://wordpress.org/plugins/cmb2/)

```php
the_meta();
echo get_post_meta( get_the_ID(), 'a_key', true );
```

**[⬆ regresar al índice](#taxonomía-personalizada)**

## Metaboxes

Las meta cajas permiten agregar cualquier tipo de contenido extra a los posts, texto, multimedia, embeds, etc.

A diferencia de los campos personalizados no son nativos de WordPress por lo que hay que habilitarlos.

### Más info

* [Codex WordPress](https://codex.wordpress.org/Function_Reference/do_meta_boxes)
* [Developers WordPress](https://developer.wordpress.org/reference/functions/add_meta_box/)
* [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/)
* [CMB2](https://wordpress.org/plugins/cmb2/)

```php
function add_a_metaboxes () {
  //7 parametros:
    // id para identificar el metabox
    // Titulo del Metabox
    // Callback con el contenido
    // Pantalla donde se mostrará
    // Contexto donde se mostrará (normal, aside, advanced)
    // Prioridad en la que se mostrará
    // Argumentos con callback

  add_meta_box( 'metabox-id', __('Metabox Title', 'mawt'), 'callback_metaboxes', 'post', 'normal', 'high', null );
}

function callback_metaboxes () {
  echo 'Content of Metaboxes';
}

add_action('add_meta_boxes', 'add_a_metaboxes');
```

**[⬆ regresar al índice](#taxonomía-personalizada)**
