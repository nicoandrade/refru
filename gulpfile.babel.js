/**
 * Gulpfile.
 *
 * Gulp with WordPress.
 *
 * Implements:
 *      1. Live reloads browser with BrowserSync.
 *      2. CSS: Sass to CSS conversion, error catching, Autoprefixing, Sourcemaps,
 *         CSS minification, and Merge Media Queries.
 *      3. JS: Concatenates & uglifies Vendor and Custom JS files.
 *      4. Images: Minifies PNG, JPEG, GIF and SVG images.
 *      5. Watches files for changes in CSS or JS.
 *      6. Watches files for changes in PHP.
 *      7. Corrects the line endings.
 *      8. InjectCSS instead of browser page reload.
 *      9. Generates .pot file for i18n and l10n.
 *
 * @basedon https://github.com/ahmadawais/WPGulp
 * @author Nico Andrade <https://twitter.com/NicoAndrade/>
 */

/**
 * Load WPGulp Configuration.
 *
 * TODO: Customize your project in the wpgulp.js file.
 */
const config = require("./wpgulp.config.js");

/**
 * Load Plugins.
 *
 * Load gulp plugins and passing them semantic names.
 */
const gulp = require("gulp"); // Gulp of-course.

// CSS related plugins.
const sass = require("gulp-sass"); // Gulp plugin for Sass compilation.
const minifycss = require("gulp-uglifycss"); // Minifies CSS files.
const autoprefixer = require("gulp-autoprefixer"); // Autoprefixing magic.
const rtlcss = require("gulp-rtlcss"); // Generates RTL stylesheet.

// JS related plugins.
const concat = require("gulp-concat"); // Concatenates JS files.
const uglify = require("gulp-uglify"); // Minifies JS files.
const babel = require("gulp-babel"); // Compiles ESNext to browser compatible JS.

// Image related plugins.
const imagemin = require("gulp-imagemin"); // Minify PNG, JPEG, GIF and SVG images with imagemin.

// Utility related plugins.
const rename = require("gulp-rename"); // Renames files E.g. style.css -> style.min.css.
const lineec = require("gulp-line-ending-corrector"); // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings).
const filter = require("gulp-filter"); // Enables you to work on a subset of the original files by filtering them using a glob.
const sourcemaps = require("gulp-sourcemaps"); // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file (E.g. structure.scss, which was later combined with other css files to generate style.css).
const notify = require("gulp-notify"); // Sends message notification to you.
const browserSync = require("browser-sync").create(); // Reloads browser and injects CSS. Time-saving synchronized browser testing.
const wpPot = require("gulp-wp-pot"); // For generating the .pot file.
const sort = require("gulp-sort"); // Recommended to prevent unnecessary changes in pot-file.
const cache = require("gulp-cache"); // Cache files in stream for later use.
const remember = require("gulp-remember"); //  Adds all the files it has ever seen back into the stream.
const plumber = require("gulp-plumber"); // Prevent pipe breaking caused by errors from gulp plugins.
const beep = require("beepbeep");

// Custom Gulp
const zip = require("gulp-zip");
const merge = require("merge-stream");
const replace = require("gulp-replace");
const params = require("yargs").argv;
const changeCase = require("change-case");
const del = require("del");


/**
 * Function: `compileCSS`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS in a function to reuse it
 *
 */
function compileCSS(fileSource, folderDestination, consoleMessage){
	return gulp
		.src(fileSource, {
			allowEmpty: true
		})
		.pipe(plumber(errorHandler))
		.pipe(
			sourcemaps.init({
				largeFile: true
			})
		)
		.pipe(
			sass({
				errLogToConsole: config.errLogToConsole,
				outputStyle: config.outputStyle,
				precision: config.precision
			})
		)
		.on("error", sass.logError)
		.pipe(
			sourcemaps.write({
				includeContent: false
			})
		)
		.pipe(
			sourcemaps.init({
				loadMaps: true
			})
		)
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write("./"))
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(folderDestination))
		.pipe(filter("**/*.css")) // Filtering stream to only css files.
		.pipe(
			minifycss({
				maxLineLen: 0
			})
		)
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(folderDestination))
		.pipe(filter("**/*.css")) // Filtering stream to only css files.
		.pipe(browserSync.stream()) // Reloads style.min.css if that is enqueued.
		.pipe(
			notify({
				message: "\n\n✅  ===> " + consoleMessage + " — completed!\n",
				onLast: true
			})
		);
}

/**
 * Custom Error Handler.
 *
 * @param Mixed err
 */
const errorHandler = r => {
	notify.onError("\n\n❌  ===> ERROR: <%= error.message %>\n")(r);
	beep();

	// this.emit('end');
};

/**
 * Task: `browser-sync`.
 *
 * Live Reloads, CSS injections, Localhost tunneling.
 * @link http://www.browsersync.io/docs/options/
 *
 * @param {Mixed} done Done.
 */
const browsersync = done => {
	browserSync.init({
		proxy: config.projectURL,
		open: config.browserAutoOpen,
		injectChanges: config.injectChanges,
		watchEvents: ["change", "add", "unlink", "addDir", "unlinkDir"]
	});
	done();
};

// Helper function to allow browser reload with Gulp 4.
const reload = done => {
	browserSync.reload();
	done();
};

/**
 * Task: `styles`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source scss file
 *    2. Compiles Sass to CSS
 *    3. Writes Sourcemaps for it
 *    4. Autoprefixes it and generates style.css
 *    5. Renames the CSS file with suffix .min.css
 *    6. Minifies the CSS file and generates style.min.css
 *    7. Injects CSS or reloads the browser via browserSync
 */
gulp.task("styles", () => {
	return gulp
		.src(config.styleSRC, {
			allowEmpty: true
		})
		.pipe(plumber(errorHandler))
		.pipe(
			sourcemaps.init({
				largeFile: true
			})
		)
		.pipe(
			sass({
				errLogToConsole: config.errLogToConsole,
				outputStyle: config.outputStyle,
				precision: config.precision
			})
		)
		.on("error", sass.logError)
		.pipe(
			sourcemaps.write({
				includeContent: false
			})
		)
		.pipe(
			sourcemaps.init({
				loadMaps: true
			})
		)
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write("./"))
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(config.styleDestination))
		.pipe(filter("**/*.css")) // Filtering stream to only css files.
		.pipe(browserSync.stream()) // Reloads style.min.css if that is enqueued.
		.pipe(
			notify({
				message: "\n\n✅  ===> STYLES — completed!\n",
				onLast: true
			})
		);
});

/**
 * Task: `adminStyles`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 */
gulp.task("adminStyles", () => {

	return compileCSS(config.adminStyleSRC, config.adminStyleDestination, "ADMIN STYLES" );

});



/**
 * Task: `editorStyles`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 */
gulp.task("editorStyles", () => {

	return compileCSS(config.editorStylesSRC, config.editorStylesDestination, "EDITOR STYLES" );
	
});


/**
 * Task: `stylesBuild`.
 *
 * Does everything the same as 'styles' but minifys the style.css for production
 *
 */
gulp.task("stylesBuild", () => {

	return compileCSS(config.styleSRC, config.styleDestination, "STYLES BUILD" );

});

/**
 * Task: `stylesRTL`.
 *
 * Compiles Sass, Autoprefixes it, Generates RTL stylesheet, and Minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source scss file
 *    2. Compiles Sass to CSS
 *    4. Autoprefixes it and generates style.css
 *    5. Renames the CSS file with suffix -rtl and generates style-rtl.css
 *    6. Writes Sourcemaps for style-rtl.css
 *    7. Renames the CSS files with suffix .min.css
 *    8. Minifies the CSS file and generates style-rtl.min.css
 *    9. Injects CSS or reloads the browser via browserSync
 */
gulp.task("stylesRTL", () => {
	return gulp
		.src(config.styleSRC, {
			allowEmpty: true
		})
		.pipe(plumber(errorHandler))
		.pipe(sourcemaps.init())
		.pipe(
			sass({
				errLogToConsole: config.errLogToConsole,
				outputStyle: config.outputStyle,
				precision: config.precision
			})
		)
		.on("error", sass.logError)
		.pipe(
			sourcemaps.write({
				includeContent: false
			})
		)
		.pipe(
			sourcemaps.init({
				loadMaps: true
			})
		)
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(
			rename({
				suffix: "-rtl"
			})
		) // Append "-rtl" to the filename.
		.pipe(rtlcss()) // Convert to RTL.
		.pipe(sourcemaps.write("./")) // Output sourcemap for style-rtl.css.
		.pipe(gulp.dest(config.styleDestination))
		.pipe(filter("**/*.css")) // Filtering stream to only css files.
		.pipe(browserSync.stream()) // Reloads style.css or style-rtl.css, if that is enqueued.
		.pipe(
			rename({
				suffix: ".min"
			})
		)
		.pipe(
			minifycss({
				maxLineLen: 10
			})
		)
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(config.styleDestination))
		.pipe(filter("**/*.css")) // Filtering stream to only css files.
		.pipe(browserSync.stream()) // Reloads style.css or style-rtl.css, if that is enqueued.
		.pipe(
			notify({
				message: "\n\n✅  ===> STYLES RTL — completed!\n",
				onLast: true
			})
		);
});

/**
 * Task: `vendorsJS`.
 *
 * Concatenate and uglify vendor JS scripts.
 *
 * This task does the following:
 *     1. Gets the source folder for JS vendor files
 *     2. Concatenates all the files and generates vendors.js
 *     3. Renames the JS file with suffix .min.js
 *     4. Uglifes/Minifies the JS file and generates vendors.min.js
 */
gulp.task("vendorsJS", () => {
	return gulp
		.src(config.jsVendorSRC, {
			since: gulp.lastRun("vendorsJS")
		}) // Only run on changed files.
		.pipe(plumber(errorHandler))
		.pipe(remember(config.jsVendorSRC)) // Bring all files back to stream.
		.pipe(concat(config.jsVendorFile + ".js"))
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(config.jsVendorDestination))
		.pipe(
			rename({
				basename: config.jsVendorFile,
				suffix: ".min"
			})
		)
		.pipe(uglify())
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(config.jsVendorDestination))
		.pipe(
			notify({
				message: "\n\n✅  ===> VENDOR JS — completed!\n",
				onLast: true
			})
		);
});

/**
 * Task: `customJS`.
 *
 * Concatenate and uglify custom JS scripts.
 *
 * This task does the following:
 *     1. Gets the source folder for JS custom files
 *     2. Concatenates all the files and generates custom.js
 *     3. Renames the JS file with suffix .min.js
 *     4. Uglifes/Minifies the JS file and generates custom.min.js
 */
gulp.task("customJS", () => {
	return gulp
		.src(config.jsCustomSRC, {
			since: gulp.lastRun("customJS")
		}) // Only run on changed files.
		.pipe(plumber(errorHandler))
		.pipe(
			babel({
				presets: [
					[
						"@babel/preset-env", // Preset to compile your modern JS to ES5.
						{
							targets: {
								browsers: config.BROWSERS_LIST
							} // Target browser list to support.
						}
					]
				]
			})
		)
		.pipe(remember(config.jsCustomSRC)) // Bring all files back to stream.
		.pipe(concat(config.jsCustomFile + ".js"))
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(config.jsCustomDestination))
		.pipe(
			rename({
				basename: config.jsCustomFile,
				suffix: ".min"
			})
		)
		.pipe(uglify())
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(config.jsCustomDestination))
		.pipe(
			notify({
				message: "\n\n✅  ===> CUSTOM JS — completed!\n",
				onLast: true
			})
		);
});

/**
 * Task: `images`.
 *
 * Minifies PNG, JPEG, GIF and SVG images.
 *
 * This task does the following:
 *     1. Gets the source of images raw folder
 *     2. Minifies PNG, JPEG, GIF and SVG images
 *     3. Generates and saves the optimized images
 *
 * This task will run only once, if you want to run it
 * again, do it with the command `gulp images`.
 *
 * Read the following to change these options.
 * @link https://github.com/sindresorhus/gulp-imagemin
 */
gulp.task("images", () => {
	return gulp
		.src(config.imgSRC)
		.pipe(
			cache(
				imagemin([
					imagemin.gifsicle({
						interlaced: true
					}),
					imagemin.jpegtran({
						progressive: true
					}),
					imagemin.optipng({
						optimizationLevel: 3
					}), // 0-7 low-high.
					imagemin.svgo({
						plugins: [
							{
								removeViewBox: true
							},
							{
								cleanupIDs: false
							}
						]
					})
				])
			)
		)
		.pipe(gulp.dest(config.imgDST))
		.pipe(
			notify({
				message: "\n\n✅  ===> IMAGES — completed!\n",
				onLast: true
			})
		);
});

/**
 * Task: `clear-images-cache`.
 *
 * Deletes the images cache. By running the next "images" task,
 * each image will be regenerated.
 */
gulp.task("clearCache", function(done) {
	return cache.clearAll(done);
});

/**
 * WP POT Translation File Generator.
 *
 * This task does the following:
 * 1. Gets the source of all the PHP files
 * 2. Sort files in stream by path or any custom sort comparator
 * 3. Applies wpPot with the variable set at the top of this file
 * 4. Generate a .pot file of i18n that can be used for l10n to build .mo file
 */
gulp.task("translate", () => {
	return gulp
		.src(config.watchPhp)
		.pipe(sort())
		.pipe(
			wpPot({
				domain: config.textDomain,
				package: config.packageName,
				bugReport: config.bugReport,
				lastTranslator: config.lastTranslator,
				team: config.team
			})
		)
		.pipe(
			gulp.dest(
				config.translationDestination + "/" + config.translationFile
			)
		)
		.pipe(
			notify({
				message: "\n\n✅  ===> TRANSLATE — completed!\n",
				onLast: true
			})
		);
});

/**
 * Task: `readmeMarkdown`.
 *
 * Creates a readme.md from the original readme.txt
 *
 */
gulp.task("readmeMarkdown", () => {
	return gulp
		.src(["./readme.txt"])
		.pipe(replace(/===(.*)===/g, "#$1")) // Replace titles with MD #
		.pipe(replace(/==(.*)==/g, "##$1"))
		.pipe(replace(/=(.*)=/g, "####$1"))
		.pipe(replace("Contributors:", "**Contributors:**"))
		.pipe(replace("Author:", "**Author:**"))
		.pipe(replace("Requires at least:", "**Requires at least:**"))
		.pipe(replace("Tested up to:", "**Tested up to:**"))
		.pipe(replace("Stable tag:", "**Stable tag:**"))
		.pipe(replace("License:", "**License:**"))
		.pipe(replace("License URI:", "**License URI:**"))
		.pipe(replace("Source:", "**Source:**"))
		.pipe(replace("Tags:", "**Tags:**"))
		.pipe(
			rename({
				extname: ".md"
			})
		)
		.pipe(gulp.dest("./"))
		.pipe(
			notify({
				message: "\n\n✅  ===> README MARKDOWN — completed!\n",
				onLast: true
			})
		);
});

/**
 * Watch Tasks.
 *
 * Watches for file changes and runs specific tasks.
 */
gulp.task(
	"default",
	gulp.parallel(
		"styles",
		"adminStyles",
		"editorStyles",
		"vendorsJS",
		"customJS",
		"images",
		"readmeMarkdown",
		browsersync,
		() => {
			gulp.watch(config.watchPhp, reload); // Reload on PHP file changes.
			gulp.watch(
				config.watchStyles,
				gulp.parallel("styles", "adminStyles", "editorStyles")
			); // Reload on SCSS file changes.
			gulp.watch(config.watchJsVendor, gulp.series("vendorsJS", reload)); // Reload on vendorsJS file changes.
			gulp.watch(config.watchJsCustom, gulp.series("customJS", reload)); // Reload on customJS file changes.
			gulp.watch(config.imgSRC, gulp.series("images", reload)); // Reload on customJS file changes.
			gulp.watch("./readme.txt", gulp.series("readmeMarkdown")); // Creates Markdown file from readme.txt
		}
	)
);

/**
 * Task: `moveFiles`.
 *
 * Creates a ZIP file with only the necessary files.
 *
 * This task will run only once, if you want to run it
 * again, do it with the command `gulp moveFiles`.
 *
 */
gulp.task("moveFiles", () => {
	return gulp
		.src([
			"./**/*",
			"!./{images/raw,images/raw/**/*}",
			"!./{node_modules,node_modules/**/*}",
			"!./assets/{sass,sass/*}",
			"!./assets/css/vendor/{bootstrap,bootstrap/**/*}",
			"!./assets/css/vendor/fontawesome-free/{scss,scss/**/*}",
			"!./assets/css/vendor/quemalabs-font/style.scss",
			"!./assets/css/vendor/quemalabs-font/style.css",
			"!./gulpfile.js",
			"!./package.json",
			"!./package-lock.json",
			"!**.DS_Store*",
			"!Thumbs.db",
			"!./gulpfile.babel.js",
			"!./wpgulp.config.js",
			"!./*.codekit3",
			"!./.gitignore",
			"!./style.scss",
			"!./style.less",
			"!./dist/"
		])
		.pipe(gulp.dest("./dist/" + config.textDomain + "/"))
		.pipe(
			notify({
				message: "\n\n✅  ===> FILES MOVED — completed!\n",
				onLast: true
			})
		);
});

/**
 * Task: `zip`.
 *
 * Creates a ZIP file with only the necessary files.
 *
 * This task will run only once, if you want to run it
 * again, do it with the command `gulp zip`.
 *
 */
gulp.task("zip", () => {
	return gulp
		.src([
			"./dist/**/*",
			"!./{images/raw,images/raw/**/*}",
			"!./{node_modules,node_modules/**/*}",
			"!./assets/{sass,sass/*}",
			"!./assets/css/vendor/{bootstrap,bootstrap/**/*}",
			"!./assets/css/vendor/fontawesome-free/{scss,scss/**/*}",
			"!./assets/css/vendor/quemalabs-font/style.scss",
			"!./assets/css/vendor/quemalabs-font/style.css",
			"!./gulpfile.js",
			"!./package.json",
			"!./package-lock.json",
			"!**.DS_Store*",
			"!Thumbs.db",
			"!./gulpfile.babel.js",
			"!./wpgulp.config.js",
			"!./*.codekit3",
			"!./.gitignore",
			"!./style.scss",
			"!./style.less",
			"!./dist/"
		])
		.pipe(zip(config.textDomain + ".zip"))
		.pipe(gulp.dest("./../"))
		.pipe(
			notify({
				message: "\n\n✅  ===> ZIP — completed!\n",
				onLast: true
			})
		);
});

/**
 * Task: `child`.
 *
 * Creates a ZIP file with a child theme starter
 *
 */
gulp.task("child", () => {
	return gulp
		.src([
			"./inc/child-theme/functions.php",
			"./inc/child-theme/style.css",
			"./screenshot.png",
			"!**.DS_Store*",
			"!Thumbs.db",
			"!./*.codekit3"
		])
		.pipe(zip(config.textDomain + "-child.zip"))
		.pipe(gulp.dest("./../"))
		.pipe(
			notify({
				message: "\n\n✅  ===> CHILD THEME — created!\n",
				onLast: true
			})
		);
});

/**
 * Task: `starter`.
 *
 * Creates a ZIP file with a new theme inside. Like a starter theme
 *
 * Command Example: npm run starter -- --name zeus
 * Command Example: npm run starter -- --name black-label
 *
 *
 */
gulp.task("starter", () => {
	return gulp
		.src([
			"./**/*",
			"!./{node_modules,node_modules/**/*}",
			"!**.DS_Store*",
			"!Thumbs.db",
			"!./*.codekit3"
		])
		.pipe(
			replace(
				changeCase.lowerCase(changeCase.snakeCase(config.textDomain)) +
					"_",
				changeCase.lowerCase(changeCase.snakeCase(params.name)) + "_"
			)
		)
		.pipe(
			replace(
				changeCase.upperCase(changeCase.snakeCase(config.textDomain)) +
					"_",
				changeCase.upperCase(changeCase.snakeCase(params.name)) + "_"
			)
		)
		.pipe(
			replace(
				changeCase.lowerCase(changeCase.paramCase(config.textDomain)) +
					"-",
				changeCase.lowerCase(changeCase.paramCase(params.name)) + "-"
			)
		)
		.pipe(
			replace(
				changeCase.lowerCase(changeCase.snakeCase(config.textDomain)) +
					".",
				changeCase.lowerCase(changeCase.snakeCase(params.name)) + "."
			)
		)
		.pipe(
			replace(
				changeCase.lowerCase(changeCase.snakeCase(config.textDomain)) +
					" ",
				changeCase.lowerCase(changeCase.snakeCase(params.name)) + " "
			)
		)
		.pipe(
			replace(
				"'" + config.textDomain + "'",
				"'" + changeCase.paramCase(params.name) + "'"
			)
		)
		.pipe(
			replace(
				'"' + config.textDomain + '"',
				'"' + changeCase.paramCase(params.name) + '"'
			)
		)
		.pipe(
			replace(
				"/" + config.textDomain + "/",
				"/" + changeCase.paramCase(params.name) + "/"
			)
		)
		.pipe(
			replace(
				changeCase.titleCase(
					changeCase.sentenceCase(config.textDomain)
				),
				changeCase.titleCase(changeCase.sentenceCase(params.name))
			)
		)
		.pipe(zip(changeCase.paramCase(params.name) + ".zip"))
		.pipe(gulp.dest("./../"))
		.pipe(
			notify({
				message: "\n\n✅  ===> STARTER ZIP — completed!\n",
				onLast: true
			})
		);
});

/**
 * Task: `files-js`.
 *
 * Moves CSS files from node_modules
 *
 */
gulp.task("files-js", () => {

	var files = gulp
		.src([
			"node_modules/bootstrap/dist/js/bootstrap.js",
		])
		.pipe(gulp.dest(config.jsVendorFolder));

	return merge(files).pipe(
		notify({
			message: "\n\n✅  ===> JS FILES moved from node_modules!\n",
			onLast: true
		})
	);
});

/**
 * Task: `files-css`.
 *
 * Moves CSS files from node_modules
 *
 */
gulp.task("files-css", () => {

	var bootstrap = gulp
		.src(["node_modules/bootstrap/scss/**/*"])
		.pipe(gulp.dest(config.styleVendorFolder + "bootstrap/"));

	var fontawesome = gulp
		.src([
			"node_modules/@fortawesome/fontawesome-free/{webfonts,webfonts/*}",
			"node_modules/@fortawesome/fontawesome-free/{scss,scss/*}"
		])
		.pipe(gulp.dest(config.styleVendorFolder + "fontawesome-free/"));

	var quemalabs_font = gulp
		.src([
			"node_modules/quemalabs-font/{fonts,fonts/*}",
			"node_modules/quemalabs-font/style.scss"
		])
		.pipe(gulp.dest(config.styleVendorFolder + "quemalabs-font/"));

	return merge(
		bootstrap,
		fontawesome,
		quemalabs_font
	).pipe(
		notify({
			message: "\n\n✅  ===> CSS FILES moved from node_modules!\n",
			onLast: true
		})
	);
});

/**
 * Task: `files`.
 *
 * Moves all the necessary plugins from node_modules to the corresponding folder
 *
 * WordPress requieres that all minified files had their original unminified file.
 *
 * This task will run only once, if you want to run it
 * again, do it with the command `gulp files`.
 *
 */
gulp.task("files", gulp.parallel("files-js", "files-css"));

/**
 * Task: `clean`.
 *
 * Clean Dist folder
 *
 * This task will run only once, if you want to run it
 * again, do it with the command `gulp clean`.
 *
 */
gulp.task("clean", () => {
	return del("dist/**", { force: true });
});

/**
 * Task: `build`.
 *
 *	Prepare all to publish the Theme and creates a ZIP file
 */
gulp.task(
	"build",
	gulp.series(
		"adminStyles",
		"editorStyles",
		"stylesBuild",
		"vendorsJS",
		"customJS",
		"images",
		"translate",
		"stylesRTL",
		"readmeMarkdown",
		"moveFiles",
		"zip",
		"clean"
	)
);
