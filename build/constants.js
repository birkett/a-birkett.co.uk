const ASSETS_DIR = './assets/';
const OUTPUT_DIR = './dist/';

const PNG_EXTENSION = '.png';
const SVG_EXTENSION = '.svg';

const SCSS_INPUT_DIR = ASSETS_DIR + 'scss/';
const CSS_OUTPUT_DIR = OUTPUT_DIR + 'css/';

const SVG_INPUT_DIR = ASSETS_DIR + 'svg/';
const IMG_OUTPUT_DIR = OUTPUT_DIR + 'img/';

const JSON_INPUT_DIR = ASSETS_DIR + 'json/';

const COMPONENT_INPUT_DIR = ASSETS_DIR + 'components/';
const TAG_TEMPLATES_INPUT_DIR = COMPONENT_INPUT_DIR + 'tagCloud/';

const FAVICON_INPUT_FILE = SVG_INPUT_DIR + 'avatar' + SVG_EXTENSION;

exports.outputDirectory = OUTPUT_DIR;

exports.pngExtension = PNG_EXTENSION;
exports.svgExtention = SVG_EXTENSION;

exports.scssInputDirectory = SCSS_INPUT_DIR;
exports.cssOutputDirectory = CSS_OUTPUT_DIR;

exports.svgInputDirectory = SVG_INPUT_DIR;
exports.imgOutputDirectory = IMG_OUTPUT_DIR;

exports.jsonInputDir = JSON_INPUT_DIR;

exports.componentInputDir = COMPONENT_INPUT_DIR;
exports.tagTemplatesInputDir = TAG_TEMPLATES_INPUT_DIR;

exports.faviconInputFile = FAVICON_INPUT_FILE;

exports.firstName = 'Anthony';
exports.lastName = 'Birkett';
exports.siteVersion = 'yyQa9x8LK9';
