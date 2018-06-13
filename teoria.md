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
+ cleanCSS - minificar el código css
+ browserify - 
+ babelify
+ source - Mejora la manupulación del código por parte de gulp
+ buffer - Mejora la manipulación de paquetes que gulp recibe
+ jsmin
+ imagemin - optimizará imágenes ESTATICAS no las dinámicas. Aunque tambíen podemos optimizar las de la carpta upload
+ wpPot - Internacionalización que genera la plantilla .pot 
+ sort

## El código de gulp
### Servidor en tiempo real

Iniciamos nuestro servidor `const reload = browserSync.reload`.
`reloadFiles` Va a ser un arreglo en donde indicamos a browserSync nuestros cambios. Indicamos:

+ JavaScript
+ CSS
+ PHP a cualquier nivel de carpeta

````javascript
 reloadFiles = [
    './script.js',
    './style.css',
    './**/*.php'
  ]
````


Ahora creamos otra variable que será la `proxyOptions` en donde indicamos los parámetros de nuestro proxy que BrowserSync necesita

`````javascript
  proxyOptions = {
    proxy: 'localhost:8080/perros/',
    notify: false
  }
`````

Creamos la primera tarea `gulp.task('server', () => browserSync.init(reloadFiles, proxyOptions))
`

## Compilar CSS Sass

La ruta de la hoja de estilos que va a estar leyendo la tarea gulp `gulp.src('./css/style.scss')`.
Vamos a ver los plugins que intervienen en la compilación de Sass:
+ `.pipe(sourcemaps.init({ loadMaps: true }))` Activa los sourcemaps de los css.
+ ` .pipe(plumber())` Evita crasch!!.
+ `.pipe(sass())` Compilación Sass.
+ `.pipe(autoprefixer({ browsers: ['last 2 versions'] }))` Prefijos para navegadores con las dos últimas versiones.
+ ` .pipe(cleanCSS())` Limpia el css resultante.
+ ` .pipe(sourcemaps.write('./css/'))` Mapea el archivo resultante.
+ `.pipe(gulp.dest('./'))` Destino.
+ ` .pipe(reload({ stream: true }))` recarga el navegador para ver los cambios.

````javascript
gulp.task('css', () => {
  gulp.src('./css/style.scss')
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(plumber())
    .pipe(sass())
    .pipe(autoprefixer({ browsers: ['last 2 versions'] }))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write('./css/'))
    .pipe(gulp.dest('./'))
    .pipe(reload({ stream: true }))
})
````
Cuando compilamos sass este no guarda ningún comentario. Si queremos guardar comentarios en el archivo css resultante tenemos que hacerlos con este formato `/*! Este comentario se mantiene por la exclamación */`

## Tarea JS

El plugins __browserify__ nos permite trabajar con módulos JS. De la misma manera que en CSS le decimos que nuestro archivo principal va a ser __style.css__ en JS vamos a indicarle que __index.js__ va a ser nuestro archivo de entrada `browserify('./js/index.js')`.
+ `.transform(babelify)` Va a empaquetar todos los módulos por medio de __bundle()__
+ Tambien vamos a tratar los errores por medio de mensaje en la consola `.on('error', err => console.log(err.message))`
+ Y el archivo resultante, después del empaquetado, va a ser __script.js__ `.pipe(source('script.js'))`
+ sourcemps queremos que se escriba en la carpeta __js__ `.pipe(sourcemaps.write('./js/'))`
+ jsmin simplifica el código `  .pipe(jsmin())`
+ Destino y recarga el servidor


`````javascript
gulp.task('js', () => {
  browserify('./js/index.js')
    .transform(babelify)
    .bundle()
    .on('error', err => console.log(err.message))
    .pipe(source('script.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(sourcemaps.write('./js/'))
    .pipe(jsmin())
    .pipe(gulp.dest('./'))
    .pipe(reload({ stream: true }))
})
`````
## ¿Cómo modularizar los archivos JS?

En el index debemos de __importar__ el módulo correspondiente; `import { suma } from './suma'` En donde suma es el archivo *.js. Con __from__ se indica la ruta.
Luego invocamos las funciones `suma(9, 7)`.

## Tareas por defecto

Por defecto (cuando solo invocamos gulp desde la terminal, sin nombre de tarea) se ejecutarán las tareas server, css y js.

Además, la tarea por defeto va a estar vigilando __watch__ los archivos css con las extensiones scss y css y si hay cambios ejecutará la tarea __css__ y lo mismo con js.


`````javascript
gulp.task('default', ['server', 'css', 'js'], () => {
  gulp.watch('./css/**/*.+(scss|css)', ['css'])
  gulp.watch('./js/**/*.js', ['js'])
})
`````

## Tareas que no necesitan ser optimizadas en tiempo real

### Las imágenes

+ imagemin `.pipe(imagemin(imageminOptions))` optimiza las imágenes. 
+ imageminOptions es una variable de opciones.
+ No es necesario comprobar constantemente las imágenes. Consumimos muchos recursos y es una tarea que solo se debe de ejecutar una vez. Por eso __esta tarea no se encuentra en la tarea default__
+ imageminOptions:
```javascript
imageminOptions = {
    progressive: true,
    optimizationLevel: 3, // 0-7 low-high
    interlaced: true,
    svgoPlugins: [{ removeViewBox: false }]
  }
```
   + progressive: true para las JPGE
   + nivel de optimización nievel medio
   + interlazado a verdadero
   + svg borrar la información de los viewBox

`````javascript
gulp.task('img', () => {
  gulp.src('./img/raw/**/*.{png,jpg,jpeg,gif,svg}')
    .pipe(imagemin(imageminOptions))
    .pipe(gulp.dest('./img'))
})
`````

### Archivos de traducción

Tarea __translate__ no necesita estar corriendo en segundo plano

+  `gulp.src('./**/*.php')` Busca en todos los archivos php
+ `.pipe(sort())` Ordenalos para mejorar el desempeño de wpPOT
+ `.pipe(wpPot(wpPotOptions))` Invocamos a wpPot con una variable __wpPotOptions__:

````javascript
 wpPotOptions = {
    domain: 'kenai',
    package: 'kenai',
    lastTranslator: 'Jonathan MirCha <jonmircha@gmail.com>'
  }
````
 + `domain: 'kenai'`, Dominio del tema
 + `package: 'kenai'` Nombre del paquete
 + `lastTranslator: 'Jonathan MirCha <jonmircha@gmail.com>'` traductor


````javascript
gulp.task('translate', () => {
  gulp.src('./**/*.php')
    .pipe(sort())
    .pipe(wpPot(wpPotOptions))
    .pipe(gulp.dest(potFile))
})
````

__No olvidar agregar en functions.php el soporte para traducción__


