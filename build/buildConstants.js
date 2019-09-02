const ASSETS_DIR = './assets/';
const OUTPUT_DIR = './dist/';

const PNG_EXTENSION = '.png';
const SVG_EXTENSION = '.svg';
const SCSS_EXTENSION = '.scss';

const SCSS_INPUT_DIR = ASSETS_DIR + 'scss/';
const CSS_OUTPUT_DIR = OUTPUT_DIR + 'css/';

const SVG_INPUT_DIR = ASSETS_DIR + 'svg/';
const IMG_OUTPUT_DIR = OUTPUT_DIR + 'img/';

const JSON_INPUT_DIR = ASSETS_DIR + 'json/';
const TEMPLATE_CONSTANTS_JSON_FILE_NAME = JSON_INPUT_DIR + 'templateConstants.json';
const HEADER_ICONS_JSON_FILE_NAME = JSON_INPUT_DIR + 'headerIcons.json';
const TAGS_JSON_FILE_NAME = JSON_INPUT_DIR + 'tagCloud.json';

const COMPONENT_INPUT_DIR = ASSETS_DIR + 'components/';

const BASE_TEMPLATE_INPUT_FILE_NAME = COMPONENT_INPUT_DIR + 'base.html.twig';
const BASE_TEMPLATE_OUTPUT_FILE_NAME = OUTPUT_DIR + 'index.html';

const WEB_MANIFEST_TEMPLATE_INPUT_FILE_NAME = COMPONENT_INPUT_DIR + 'webManifest.json.twig';
const WEB_MANIFEST_OUTPUT_FILE_NAME = OUTPUT_DIR + 'site.webmanifest';

const FAVICON_INPUT_FILE = SVG_INPUT_DIR + 'avatar' + SVG_EXTENSION;
const SAFARI_ICON_FILE_NAME = OUTPUT_DIR + 'safari-pinned-tab' + SVG_EXTENSION;

exports.outputDirectory = OUTPUT_DIR;

exports.pngExtension = PNG_EXTENSION;
exports.svgExtention = SVG_EXTENSION;
exports.scssExtention = SCSS_EXTENSION;

exports.scssInputDirectory = SCSS_INPUT_DIR;
exports.cssOutputDirectory = CSS_OUTPUT_DIR;

exports.svgInputDirectory = SVG_INPUT_DIR;
exports.imgOutputDirectory = IMG_OUTPUT_DIR;

exports.jsonInputDir = JSON_INPUT_DIR;
exports.templateConstantsJsonPath = TEMPLATE_CONSTANTS_JSON_FILE_NAME;
exports.headerIconsJsonPath = HEADER_ICONS_JSON_FILE_NAME;
exports.tagsJsonPath = TAGS_JSON_FILE_NAME;

exports.componentInputDir = COMPONENT_INPUT_DIR;

exports.templateInputFileName = BASE_TEMPLATE_INPUT_FILE_NAME;
exports.templateOutputFileName = BASE_TEMPLATE_OUTPUT_FILE_NAME;

exports.webManifestInputFileName = WEB_MANIFEST_TEMPLATE_INPUT_FILE_NAME;
exports.webManifestOutputFileName = WEB_MANIFEST_OUTPUT_FILE_NAME;

exports.faviconInputFile = FAVICON_INPUT_FILE;
exports.safariIconFileName = SAFARI_ICON_FILE_NAME;
