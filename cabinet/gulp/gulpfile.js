var gulp         = require('gulp'), // Подключаем Gulp
    sass         = require('gulp-sass'), //Подключаем Sass пакет,
    browserSync  = require('browser-sync'), // Подключаем Browser Sync
    concat       = require('gulp-concat'), // Подключаем gulp-concat (для конкатенации файлов)
    rename       = require('gulp-rename'), // Подключаем библиотеку для переименования файлов
    del          = require('del'), // Подключаем библиотеку для удаления файлов и папок
    cache        = require('gulp-cache'), // Подключаем библиотеку кеширования
    autoprefixer = require('gulp-autoprefixer'), // Подключаем библиотеку для автоматического добавления префиксов
    spritesmith  = require('gulp.spritesmith'), // Подключаем библиотеку для создания спрайтов
    buffer       = require('vinyl-buffer'), // Буфер
    merge        = require('merge-stream'),
    sourcemaps   = require('gulp-sourcemaps');

// Удаление старых спрайтов
gulp.task('spriteClean', function() {
    return del.sync('../web/images/sprite/sprite.png', {
        force: true,
    }); // Удаляем спрайт перед созданием нового
});

// Создание спрайтов
gulp.task('sprite', ['spriteClean'], function () {

    var spriteData = gulp.src('../web/images/sprite/*.png').pipe(spritesmith({

        imgName: '../web/images/sprite/sprite.png',
        imgPath: '../web/images/sprite/sprite.png?v=' + Math.floor((new Date()).getTime() / 1000),
        cssName: '_sprite.scss',
        algorithm: 'binary-tree' // Вид генерации спрайтов

    }));

  var imgStream = spriteData.img

    .pipe(buffer())
    .pipe(gulp.dest('../web//images/'));

  var cssStream = spriteData.css
    .pipe(gulp.dest('../web/scss/'));

  return merge(imgStream, cssStream);

});

gulp.task('sass', function(){ // Создаем таск Sass
    return gulp.src('../web/scss/**/*.scss') // Берем источник
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError)) // Преобразуем Sass в CSS посредством gulp-sass
        .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], { cascade: true })) // Создаем префиксы
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('../web/css')) // Выгружаем результата в папку app/css
        .pipe(browserSync.reload({stream: true})) // Обновляем CSS на странице при изменении
});

gulp.task('browser-sync', function() {
    browserSync({
        proxy: "http://aparkrent.gc/",
        open: true,
        notify: false
    });
});



gulp.task('watch', ['browser-sync'], function() {
    gulp.watch('../web/scss/**/*.scss', ['sass']); // Наблюдение за sass файлами в папке sass
    gulp.watch('../views/**/*.php', browserSync.reload); // Наблюдение за PHP файлами в корне проекта
    gulp.watch('../web/js/**/*.js', browserSync.reload); // Наблюдение за JS файлами в папке js
});

gulp.task('clear', function (callback) {
    return cache.clearAll();
});

gulp.task('default', ['watch']);

