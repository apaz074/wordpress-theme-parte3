<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Título del Sitio</title>
  <meta name="description" content="Descripción del Sitio">
  <?php wp_head(); ?>
</head>
<body>
    <header class="Header">
      <section class="Header-container">
        <div class="Logo">
          <a href="#">Logo</a>
        </div>
        <button class="Menu-btn">Menú Principal</button>
        <nav class="Menu">
          <ul>
            <li><a href="#">Sección 1</a></li>
            <li><a href="#">Sección 2</a></li>
            <li><a href="#">Sección 3</a></li>
            <li><a href="#">Sección 4</a></li>
            <li><a href="#">Sección 5</a></li>
          </ul>
        </nav>
      </section>
    </header>
    <section class="Content">
      <div class="Content-container">
        <main class="Main">
          <h2>Contenido Principal</h2>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis reprehenderit, obcaecati voluptatum aliquid hic dolorem perspiciatis iure? Vero architecto eius earum aliquid porro doloribus voluptate. Id debitis tempora tenetur deleniti?
          </p>
          <p>
          <?php
            _e('Hola', 'kenai');
          ?>
          </p>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis reprehenderit, obcaecati voluptatum aliquid hic dolorem perspiciatis iure? Vero architecto eius earum aliquid porro doloribus voluptate. Id debitis tempora tenetur deleniti?
          </p>
          <img src="https://placeimg.com/400/400/any">
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis reprehenderit, obcaecati voluptatum aliquid hic dolorem perspiciatis iure? Vero architecto eius earum aliquid porro doloribus voluptate. Id debitis tempora tenetur deleniti?
          </p>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis reprehenderit, obcaecati voluptatum aliquid hic dolorem perspiciatis iure? Vero architecto eius earum aliquid porro doloribus voluptate. Id debitis tempora tenetur deleniti?
          </p>
          <img src="https://placeimg.com/400/400/any">
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis reprehenderit, obcaecati voluptatum aliquid hic dolorem perspiciatis iure? Vero architecto eius earum aliquid porro doloribus voluptate. Id debitis tempora tenetur deleniti?
          </p>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis reprehenderit, obcaecati voluptatum aliquid hic dolorem perspiciatis iure? Vero architecto eius earum aliquid porro doloribus voluptate. Id debitis tempora tenetur deleniti?
          </p>
          <p>
          <?php
            echo __('Adios', 'kenai');
          ?>
          </p>
          <img src="https://placeimg.com/400/400/any">
        </main>
        <aside class="Sidebar">
          <h2>Contenido Lateral</h2>
          <article class="Widget">
            <h3>Buscar:</h3>
            <form>
              <input type="text">
              <input type="submit" value="Buscar">
            </form>
          </article>
          <article class="Widget">
            <h3>Últimas Entradas:</h3>
            <ul>
              <li><a href="#">Entrada 1</a></li>
              <li><a href="#">Entrada 2</a></li>
              <li><a href="#">Entrada 3</a></li>
              <li><a href="#">Entrada 4</a></li>
              <li><a href="#">Entrada 5</a></li>
            </ul>
          </article>
          <article class="Widget">
            <h3>Otro Widget:</h3>
            <div>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum, blanditiis aut? Placeat veniam iste quae molestias eius asperiores voluptatibus, quis voluptatum accusantium alias praesentium, et eum exercitationem accusamus, delectus repellendus?</p>
              <img src="https://placeimg.com/400/400/any">
            </div>
          </article>
        </aside>
      </div>
    </section>
    <footer class="Footer">
      <section class="Footer-container">
        <div>
          <nav class="SocialMedia">
            <ul>
              <li><a href="https://facebook.com" target="_blank">facebook</a></li>
              <li><a href="https://twitter.com" target="_blank">twitter</a></li>
              <li><a href="https://github.com" target="_blank">github</a></li>
              <li><a href="https://codepen.io" target="_blank">codepen</a></li>
              <li><a href="https://youtube.com" target="_blank">youtube</a></li>
              <li><a href="https://instagram.com" target="_blank">instagram</a></li>
            </ul>
          </nav>
        </div>
        <div>
          <p>
            &copy; 2018 Copyright
            <a href="https://jonmircha.com" target="_blank">@jonmircha</a>.
          </p>
        </div>
      </section>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
