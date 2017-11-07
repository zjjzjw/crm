//var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

//elixir(function(mix) {
//    mix.less('app.less');
//});
var gulp = require('gulp');
var header = require('gulp-header');
var footer = require('gulp-footer');
var concat = require('gulp-concat');
var jshint = require('gulp-jshint');
var cached = require('gulp-cached');
var remember = require('gulp-remember');

var scriptsGlob = 'src/**/*.js';

gulp.task('scripts', function() {
  return gulp.src(scriptsGlob)
      .pipe(cached('scripts'))        // 只传递更改过的文件
      .pipe(jshint())                 // 对这些更改过的文件做一些特殊的处理...
      .pipe(header('(function () {')) // 比如 jshinting ^^^
      .pipe(footer('})();'))          // 增加一些类似模块封装的东西
      .pipe(remember('scripts'))      // 把所有的文件放回 stream
      .pipe(concat('app.js'))         // 做一些需要所有文件的操作
      .pipe(gulp.dest('public/'));
});


gulp.task('default' , function() {
    var notify = require('gulp-notify');
    gulp.src([
            './public/www/js/lib/jquery/jquery.min.js',
        ])
        .pipe(gulp.dest('./public/built/js/common.js'))
        .pipe(notify({message: 'Common Scripts (not IE) concat task complete'}));
});



gulp.task('watch', function () {
  var watcher = gulp.watch(scriptsGlob, ['scripts']); // 监视与 scripts 任务中同样的文件
  watcher.on('change', function (event) {
    if (event.type === 'deleted') {                   // 如果一个文件被删除了，则将其忘记
      delete cached.caches.scripts[event.path];       // gulp-cached 的删除 api
      remember.forget('scripts', event.path);         // gulp-remember 的删除 api
    }
  });
});