/**
 * WPGulp Configuration File
 *
 * 1. Edit the variables as per your project requirements.
 * 2. In paths you can add <<glob or array of globs>>.
 *
 * @package WPGulp
 */

module.exports = {
    // Project options.
    projectURL: "http://localhost/Refru/", // Local project URL of your already running WordPress site. Could be something like wpgulp.local or localhost:3000 depending upon your local WordPress setup.
    productURL: "./", // Theme/Plugin URL. Leave it like it is, since our gulpfile.js lives in the root folder.
    browserAutoOpen: false,
    injectChanges: true,

    // Style options.
    styleSRC: "./assets/css/style.scss", // Path to main .scss file.
    styleDestination: "./", // Path to place the compiled CSS file. Default set to root folder.
    outputStyle: "compact", // Available options → 'compact' or 'compressed' or 'nested' or 'expanded'
    outputStyleBuild: "compressed", // Available options → 'compact' or 'compressed' or 'nested' or 'expanded'
    errLogToConsole: true,
    precision: 10,

    // JS Vendor options.
    jsVendorSRC: "./assets/js/vendor/*.js", // Path to JS vendor folder.
    jsVendorDestination: "./js/", // Path to place the compiled JS vendors file.
    jsVendorFile: "vendor", // Compiled JS vendors file name. Default set to vendors i.e. vendors.js.

    // JS Custom options.
    jsCustomSRC: "./assets/js/custom/*.js", // Path to JS custom scripts folder.
    jsCustomDestination: "./js/", // Path to place the compiled JS custom scripts file.
    jsCustomFile: "custom", // Compiled JS custom file name. Default set to custom i.e. custom.js.

    // Images options.
    imgSRC: "./images/raw/*", // Source folder of images which should be optimized and watched. You can also specify types e.g. raw/**.{png,jpg,gif} in the glob.
    imgDST: "./images/", // Destination folder of optimized images. Must be different from the imagesSRC folder.

    // Watch files paths.
    watchStyles: "./assets/css/**/*.scss", // Path to all *.scss files inside css folder and inside them.
    watchJsVendor: "./assets/js/vendor/*.js", // Path to all vendor JS files.
    watchJsCustom: "./assets/js/custom/*.js", // Path to all custom JS files.
    watchPhp: "./**/*.php", // Path to all PHP files.

    // Translation options.
    textDomain: "refru", // Your textdomain here.
    translationFile: "refru.pot", // Name of the translation file.
    translationDestination: "./languages", // Where to save the translation files.
    packageName: "refru", // Package name.
    bugReport: "https://www.quemalabs.com/", // Where can users report bugs.
    lastTranslator: "Nico Andrade <nicoandrade@gmail.com>", // Last translator Email ID.
    team: "Nico Andrade <nicoandrade@gmail.com>", // Team's Email ID.

    // Browsers you care about for autoprefixing. Browserlist https://github.com/ai/browserslist
    // The following list is set as per WordPress requirements. Though, Feel free to change.
    BROWSERS_LIST: [
        "last 2 version",
        "> 1%",
        "ie >= 11",
        "last 1 Android versions",
        "last 1 ChromeAndroid versions",
        "last 2 Chrome versions",
        "last 2 Firefox versions",
        "last 2 Safari versions",
        "last 2 iOS versions",
        "last 2 Edge versions",
        "last 2 Opera versions"
    ],

    // Custom
    styleVendorFolder: "./assets/css/vendor/", // Path to CSS vendor folder only.
    jsVendorFolder: "./assets/js/vendor/", // Path to JS vendor folder only.
    fontsFolder: "./fonts/", // Path to web fonts folder

    // Admin Style options.
    adminStyleSRC: "./assets/css/admin-styles.scss", // Path to admin .scss file.
    adminStyleDestination: "./css/", // Path to place the compiled CSS file. Default set to root folder.

    // Editor Styles options.
    editorStylesSRC: "./assets/css/style-editor.scss", // Path to admin .scss file.
    editorStylesDestination: "./css/" // Path to place the compiled CSS file. Default set to root folder.
};
