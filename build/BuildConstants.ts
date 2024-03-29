import * as childProcess from 'child_process';
import { memoize } from '@memoize/Memoize';

const ASSETS_DIR = './assets/';
const OUTPUT_DIR = './dist/';

const SVG_INPUT_DIR = `${ASSETS_DIR}svg/`;
const JSON_INPUT_DIR = `${ASSETS_DIR}json/`;
const COMPONENT_INPUT_DIR = `${ASSETS_DIR}components/`;

const WEB_MANIFEST_OUTPUT_FILE_NAME = 'site.webmanifest';
const SAFARI_ICON_FILE_NAME = 'safari-pinned-tab.svg';

const SERVICE_WORKER_OUTPUT_FILE_NAME = 'serviceWorker.js';
const SERVICE_WORKER_URCHIN_OUTPUT_FILE_NAME = 'serviceWorkerUrchin.js';

export const BuildConstants = {
    outputDirectory: OUTPUT_DIR,

    scssInputDirectory: `${ASSETS_DIR}scss/`,
    cssOutputDirectory: `${OUTPUT_DIR}css/`,

    svgInputDirectory: SVG_INPUT_DIR,
    imgOutputDirectory: `${OUTPUT_DIR}img/`,

    fontInputDirectory: `${ASSETS_DIR}fonts/`,
    fontOutputDirectory: `${OUTPUT_DIR}fonts/`,

    templateConstantsJsonPath: `${JSON_INPUT_DIR}templateConstants.json`,
    headerLinksJsonPath: `${JSON_INPUT_DIR}headerLinks.json`,
    tagsJsonPath: `${JSON_INPUT_DIR}tagCloud.json`,

    templateOutputFileName: `${OUTPUT_DIR}index.html`,

    serviceWorkerOutputFileName: `${SERVICE_WORKER_OUTPUT_FILE_NAME}`,
    serviceWorkerInputFileName: `${COMPONENT_INPUT_DIR}serviceWorker.js.njk`,
    serviceWorkerOutputPath: `${OUTPUT_DIR}${SERVICE_WORKER_OUTPUT_FILE_NAME}`,

    serviceWorkerUrchinOutputFileName: `${SERVICE_WORKER_URCHIN_OUTPUT_FILE_NAME}`,
    serviceWorkerUrchinInputFileName: `${COMPONENT_INPUT_DIR}serviceWorkerUrchin.js.njk`,
    serviceWorkerUrchinOutputPath: `${OUTPUT_DIR}${SERVICE_WORKER_URCHIN_OUTPUT_FILE_NAME}`,

    webManifestInputFileName: `${COMPONENT_INPUT_DIR}webManifest.json.njk`,
    webManifestFileName: WEB_MANIFEST_OUTPUT_FILE_NAME,
    webManifestOutputFileName: `${OUTPUT_DIR}${WEB_MANIFEST_OUTPUT_FILE_NAME}`,

    browserConfigInputFileName: `${COMPONENT_INPUT_DIR}browserConfig.xml.njk`,
    browserConfigOutputFileName: `${OUTPUT_DIR}browserconfig.xml`,

    faviconInputFile: `${SVG_INPUT_DIR}avatar.svg`,
    safariIconFileName: SAFARI_ICON_FILE_NAME,
    safariIconOutputFileName: `${OUTPUT_DIR}${SAFARI_ICON_FILE_NAME}`,

    fontFileName: 'francois-one-v14-latin-regular.woff2',
    outputCssFileName: 'main.css',

    faviconPrefix: 'favicon',

    themeColor: '#000000',
    msTileColor: '#2B5797',

    gitRevision: memoize<string>((): string => {
        const stdOut = childProcess.execSync('git rev-parse --short HEAD');

        return stdOut.toString().split('\n').join('');
    }),
};
