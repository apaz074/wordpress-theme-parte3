<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php bloginfo( 'name' ); ?></title>
  <meta name="description" content="<?php bloginfo( 'description' ); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="Header">
      <section class="Header-container">
        <div class="Logo">
          <a href="<?php echo esc_url( home_url( '/' )  );  ?>">Logo</a>
        </div>
        <button class="Panel-btn"><?php _e('Menú Principal', 'mawt');  ?></button>
        <section class="Panel">
          <nav class="Menu">
            <ul>
              <?php wp_list_pages('title_li'); ?>
            </ul>
          </nav>
        </section>
      </section>
    </header>
    <section class="Content">