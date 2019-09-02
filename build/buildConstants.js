const ASSETS_DIR = './assets/';
const OUTPUT_DIR = './dist/';

const PNG_EXTENSION = '.png';
const SVG_EXTENSION = '.svg';
const SCSS_EXTENSION = '.scss';
const CSS_EXTENSION = '.css';
const ICO_EXTENSION = '.ico';
const JSON_EXTENSION = '.json';
const WEB_MANIFEST_EXTENSION = '.webmanifest';
const XML_EXTENSION = '.xml';

const SVG_INPUT_DIR = ASSETS_DIR + 'svg/';
const JSON_INPUT_DIR = ASSETS_DIR + 'json/';
const COMPONENT_INPUT_DIR = ASSETS_DIR + 'components/';

const WEB_MANIFEST_OUTPUT_FILE_NAME = 'site' + WEB_MANIFEST_EXTENSION;
const BROWSER_CONFIG_OUTPUT_FILE_NAME = 'browserconfig' + XML_EXTENSION;
const SAFARI_ICON_FILE_NAME = 'safari-pinned-tab' + SVG_EXTENSION;

exports.outputDirectory = OUTPUT_DIR;

exports.pngExtension = PNG_EXTENSION;
exports.svgExtension = SVG_EXTENSION;
exports.scssExtension = SCSS_EXTENSION;
exports.cssExtension = CSS_EXTENSION;
exports.icoExtension = ICO_EXTENSION;

exports.scssInputDirectory = ASSETS_DIR + 'scss/';
exports.cssOutputDirectory = OUTPUT_DIR + 'css/';

exports.svgInputDirectory = SVG_INPUT_DIR;
exports.imgOutputDirectory = OUTPUT_DIR + 'img/';

exports.jsonInputDir = JSON_INPUT_DIR;
exports.templateConstantsJsonPath = JSON_INPUT_DIR + 'templateConstants' + JSON_EXTENSION;
exports.headerIconsJsonPath = JSON_INPUT_DIR + 'headerIcons' + JSON_EXTENSION;
exports.tagsJsonPath = JSON_INPUT_DIR + 'tagCloud' + JSON_EXTENSION;

exports.componentInputDir = COMPONENT_INPUT_DIR;

exports.templateInputFileName = COMPONENT_INPUT_DIR + 'base.html.twig';
exports.templateOutputFileName = OUTPUT_DIR + 'index.html';

exports.webManifestInputFileName = COMPONENT_INPUT_DIR + 'webManifest.json.twig';
exports.webManifestFileName = WEB_MANIFEST_OUTPUT_FILE_NAME;
exports.webManifestOutputFileName = OUTPUT_DIR + WEB_MANIFEST_OUTPUT_FILE_NAME;

exports.browserConfigInputFileName = COMPONENT_INPUT_DIR + 'browserConfig.xml.twig';
exports.browserConfigOutputFileName = OUTPUT_DIR + BROWSER_CONFIG_OUTPUT_FILE_NAME;

exports.faviconInputFile = SVG_INPUT_DIR + 'avatar' + SVG_EXTENSION;
exports.safariIconFileName = SAFARI_ICON_FILE_NAME;
exports.safariIconOutputFileName= OUTPUT_DIR + SAFARI_ICON_FILE_NAME;

exports.faviconPrefix = 'favicon';
exports.appleIconPrefix = 'apple-touch-icon';
exports.androidIconPrefix = 'android-chrome';
exports.msTileIconPrefix = 'mstile';

exports.themeColor = '#000000';
exports.msTileColor = '#2B5797';
