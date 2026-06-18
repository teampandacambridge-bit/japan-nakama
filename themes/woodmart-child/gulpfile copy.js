const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const browserSync = require("browser-sync").create();
const sourcemaps = require("gulp-sourcemaps");
const concat = require("gulp-concat");
const minify = require("gulp-minify");
const rename = require("gulp-rename");

var paths = {
    sourceDir: "src",
    outputDir: "assets",
};

var buildpath = paths["sourceDir"];
var outputpath = paths["outputDir"];

// Main CSS
function main() {
    return gulp
        .src(buildpath + "/scss/main.scss")
        .pipe(sourcemaps.init())
        .pipe(sass({ outputStyle: "compressed" }))
        .pipe(rename({ suffix: ".min" }))
        .pipe(gulp.dest(outputpath + "/css/"))
        .pipe(browserSync.stream());
}

// Critical CSS
function critical() {
    return gulp
        .src(buildpath + "/scss/critical.scss")
        .pipe(sourcemaps.init())
        .pipe(sass({ outputStyle: "compressed" }))
        .pipe(rename({ suffix: ".min" }))
        .pipe(gulp.dest(outputpath + "/css/"))
        .pipe(browserSync.stream());
}

// JavaScript
function javascript() {
    return gulp
        .src(buildpath + "/js/**/*.js")
        .pipe(concat("init.js"))
        .pipe(
            minify({
                ext: {
                    min: ".min.js",
                },
                noSource: true,
            })
        )
        .pipe(gulp.dest(outputpath + "/js/"))
        .pipe(browserSync.stream());
}

// Images (placeholder for future image optimization task)
function compImage(done) {
    done(); // Placeholder for future code
}

// Watch files
function watch() {
    browserSync.init({
        proxy: "http://japannakama.local/travel",
    });

    // Watch SASS files
    gulp.watch(buildpath + "/scss/**/*.scss", gulp.series(main, critical));

    // Watch PHP files
    gulp.watch(["**/*.php", "*.php"]).on("change", browserSync.reload);

    // Watch JS files
    gulp.watch(buildpath + "/js/*.js", gulp.series(javascript));
}

// Task exports
exports.critical = critical;
exports.main = main;
exports.javascript = javascript;
exports.watch = watch;
exports.compImage = compImage;

// Default task (compile CSS)
const compileCSS = gulp.series(main, critical);
exports.default = compileCSS;
