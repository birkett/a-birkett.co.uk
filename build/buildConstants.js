const fs = require('fs');

const ASSETS_DIR = './assets/';
const OUTPUT_DIR = './dist/';

const PNG_EXTENSION = '.png';
const SVG_EXTENSION = '.svg';
const SCSS_EXTENSION = '.scss';
const CSS_EXTENSION = '.css';
const ICO_EXTENSION = '.ico';
const JSON_EXTENSION = '.json';

const SVG_INPUT_DIR = ASSETS_DIR + 'svg/';
const JSON_INPUT_DIR = ASSETS_DIR + 'json/';
const COMPONENT_INPUT_DIR = ASSETS_DIR + 'components/';

const WEB_MANIFEST_OUTPUT_FILE_NAME = 'site.webmanifest';
const SAFARI_ICON_FILE_NAME = 'safari-pinned-tab' + SVG_EXTENSION;

module.exports = {
    outputDirectory: OUTPUT_DIR,

    pngExtension: PNG_EXTENSION,
    svgExtension: SVG_EXTENSION,
    scssExtension: SCSS_EXTENSION,
    cssExtension: CSS_EXTENSION,
    icoExtension: ICO_EXTENSION,

    scssInputDirectory: ASSETS_DIR + 'scss/',
    cssOutputDirectory: OUTPUT_DIR + 'css/',

    svgInputDirectory: SVG_INPUT_DIR,
    imgOutputDirectory: OUTPUT_DIR + 'img/',

    jsonInputDir: JSON_INPUT_DIR,
    templateConstantsJsonPath: JSON_INPUT_DIR + 'templateConstants' + JSON_EXTENSION,
    headerLinksJsonPath: JSON_INPUT_DIR + 'headerLinks' + JSON_EXTENSION,
    tagsJsonPath: JSON_INPUT_DIR + 'tagCloud' + JSON_EXTENSION,

    componentInputDir: COMPONENT_INPUT_DIR,

    templateInputFileName: COMPONENT_INPUT_DIR + 'index.html.twig',
    templateOutputFileName: OUTPUT_DIR + 'index.html',

    webManifestInputFileName: COMPONENT_INPUT_DIR + 'webManifest.json.twig',
    webManifestFileName: WEB_MANIFEST_OUTPUT_FILE_NAME,
    webManifestOutputFileName: OUTPUT_DIR + WEB_MANIFEST_OUTPUT_FILE_NAME,

    browserConfigInputFileName: COMPONENT_INPUT_DIR + 'browserConfig.xml.twig',
    browserConfigOutputFileName: OUTPUT_DIR + 'browserconfig.xml',

    faviconInputFile: SVG_INPUT_DIR + 'avatar' + SVG_EXTENSION,
    safariIconFileName: SAFARI_ICON_FILE_NAME,
    safariIconOutputFileName: OUTPUT_DIR + SAFARI_ICON_FILE_NAME,

    faviconPrefix: 'favicon',
    appleIconPrefix: 'apple-touch-icon',
    androidIconPrefix: 'android-chrome',
    msTileIconPrefix: 'mstile',

    themeColor: '#000000',
    msTileColor: '#2B5797',

    siteVersion: function () {
        let siteVersion = '';

        if (fs.existsSync(OUTPUT_DIR + 'site.version')) {
            siteVersion = fs.readFileSync(OUTPUT_DIR + 'site.version').toString();
        }

        return siteVersion;
    }
};
