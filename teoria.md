# Automatizando tareas con Gulp

Babel
```    "babel-core": "^6.26.3",
    "babel-preset-env": "^1.7.0",
    "babelify": "^8.0.0", 
```

Para usar los import `"babelify": "^8.0.0"`

Todos los módulos que vamos a usar

````javascript
import gulp from 'gulp'
import browserSync from 'browser-sync'
import plumber from 'gulp-plumber'
import sass from 'gulp-sass'
import sourcemaps from 'gulp-sourcemaps'
import autoprefixer from 'gulp-autoprefixer'
import cleanCSS from 'gulp-clean-css'
import browserify from 'browserify'
import babelify from 'babelify'
import source from 'vinyl-source-stream'
import buffer from 'vinyl-buffer'
import jsmin from 'gulp-jsmin'
import imagemin from 'gulp-imagemin'
import wpPot from 'gulp-wp-pot'
import sort from 'gulp-sort'
````

+ gulp - ejecutar tareas
+ browserSync - ejecutar el servidor
+ plumber - error de sintaxis por ejemplo de sass __evita detener todo el proceso__ el lo reinicia.
+ sass - Compilador de CSS en SASS
+ sourcemaps - Mapeador del codigo css para saber la linea exacta en donde se ha producido el error.
+ autoprefixer - prefijos en css automático para versiones anteriores de los navegadores.
+ cleanCSS
+ browserify
+ babelify
+ source
+ buffer
+ jsmin
+ imagemin
+ wpPot
+ sort