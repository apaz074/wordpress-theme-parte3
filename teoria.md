# Starter Themes
## Generando tema base con underscores

[enlace de interes sobre WP y StarterThemes](https://betabeers.com/blog/starter-themes-wordpress-355/)

¿Qué es un Starter Theme para WordPress?
Un tema starter para WordPress es un conjunto de archivos de plantillas de contenido para WordPress complementado con un diseño mínimo en la mayor parte de ocasiones o incluso inexistente en otros casos.

Tendremos por lo tanto los archivos necesarios para mostrar el contenido de entradas, páginas, comentarios, categorías, etiquetas y otros tipos de contenido de WordPress, pero sin incluir apenas estilos, lo cual, nos permitirá decidir cuales son los elementos que queremos definir en la hoja de estilos del sitio web durante el proceso de maquetación.

Si queremos elegir el starter theme que se adapte mejor a nuestras necesidades, conocimientos o forma de trabajar deberemos seguir algunas premisas.

## Analizando el contenido del starter themes

__inc__ nos trae modulos establecidos. Como minifuctions tal y como veniamos haciendo hasta ahora.

__functions.php__

Controla que la función exista

+ `if ( ! function_exists( 'undersore_theme_start_setup' ) ) :`

Carga para los idiomas
+ `load_theme_textdomain( 'undersore_theme_start', get_template_directory() . '/languages' );
`
Soporte para los enlaces de alimentacion automático rss

+ `add_theme_support( 'automatic-feed-links' );`

Soporte al título

+ `add_theme_support( 'title-tag' );`

Registrando solo un menú

+`register_nav_menus( array(
    'menu-1' => esc_html__( 'Primary', 'undersore_theme_start' ),
   ) );`

Soporte para HTML 5

+ `add_theme_support( 'html5', array(
   			'search-form',
   			'comment-form',
   			'comment-list',
   			'gallery',
   			'caption',
   		) );`

Color de fondo de la cabecera

+ `add_theme_support( 'custom-background', apply_filters( 'undersore_theme_start_custom_background_args', array(
   			'default-color' => 'ffffff',
   			'default-image' => '',
   		) ) );`

Customización. Que aparezca el lapiz en la personalización del tema

+ `add_theme_support( 'customize-selective-refresh-widgets' );`

Esta es muy importante __el tamaño máximo de todos los contenidos que se vaya incrustando, videos, imágenes...__

+ `$GLOBALS['content_width'] = apply_filters( 'undersore_theme_start_content_width', 640 );`

````php
<?
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function undersore_theme_start_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'undersore_theme_start_content_width', 640 );
}
add_action( 'after_setup_theme', 'undersore_theme_start_content_width', 0 );
````

Registra un widget

````php
function undersore_theme_start_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'undersore_theme_start' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'undersore_theme_start' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'undersore_theme_start_widgets_init' );

````
También llama a los archivos css y js

````php
/**
 * Enqueue scripts and styles.
 */
function undersore_theme_start_scripts() {
	wp_enqueue_style( 'undersore_theme_start-style', get_stylesheet_uri() );

	wp_enqueue_script( 'undersore_theme_start-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'undersore_theme_start-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'undersore_theme_start_scripts' );

````

Y por último a los __módulos__ dentro de __inc__ de funciones

```php
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
/*....etc*/
```

Vemos tb que trae un carpeta __js__ con diferentes script para el tema.

La carpeta __languages__ trae una plantilla para poedit de los archivos *.pot

La carpeta __layouts__ nos da la opcion de la disposición de los elementos. sidebar a la izquierda o derecha, dos columnas, contenido a plantalla completa...etc

La carperta __template-parts__ con los tipos de contenidos.

El archivo __rtl.css__ para idiomas que se leen de izquierda a derecha.

## Tema base con HTML Blank

Analizamos lo que trae html5blanck-stable

__searchform.php__ un buscador con resultados personalizados. Si queremos tener resultados personalizados de las busquedas debemos añadir este archivo.

## Estructura de nuestro starter theme

Vamos a crear una carpeta base de nombre __kenai_starter_theme__ En ella vamos a incluir nuestros archivos mínimos necesarios para comenzar con nuestro tema.

Los archimos mínimos son; 

+ index.php
+ style.css
+ functions.php
+ screenshot.png

Además usamos __gitignore__ para __git__

Lo primero que vamos a hacer es editar los estilos básicos que va a requerir nuestro tema. 
Comenzamos por editar los __comentarios__ especiales para que WP reconozca el nombre, versión del tema y luego las palabras clave del mismo 

````css
    /*!
    Theme Name: kEnAi WP Starter Theme
    Theme URI: https://github.com/jonmircha.com/kenia-wp-starter-theme/
    Author: Jonathan MirCha
    Author URI: https://jonmircha.com/
    Description: An easy and simple starter theme for WordPress with generals assets like pages, post, categories, tags, authors, searchs, etc. Optimized with Grid CSS and Custom Properties.
    Version: 1.0.0
    License: GNU General Public License v2 or later
    License URI: http://www.gnu.org/licenses/gpl-2.0.html
    Tags: one-column, two-columns, right-sidebar, left-sidebar, full-width, flexible-header, accessibility-ready, custom-colors, custom-header, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, post-formats, theme-options, translation-ready, grid-css, custom-properties, css-variables, starter-theme, jonmircha, kenai, dogs
    Text Domain: kenai
    */
````

Nombre del tema `kEnAi WP Starter Theme`, Desde donde se puede descargar `Theme URI: https://github.com/jonmircha.com/kenia-wp-starter-theme/` y además las __tags__ que describen a grandes rasgos las características del tema `Tags: one-column, two-columns, right-sidebar, left-sidebar, full-width, flexible-header, accessibility-ready, custom-colors, custom-header, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, post-formats, theme-options, translation-ready, grid-css, custom-properties, css-variables, starter-theme, jonmircha, kenai, dogs`

Estructura de carpetas:
+ css - estilos
+ img - imágenes estáticas del proyecto
+ js - scripts js
+ inc - funciones de functions extras
+ layouts - variantes de diseño a nuestras páginas
+ template-part - dependiendo del tipo de contenido
+ languajes - idiomas soportados y archivos de traducción

En gulp vamos a dar soporte a css y js


