const constants = require('../constants');
const fs = require('fs');
const iconGen = require('icon-gen');

const INTERMEDIATE_FILENAME = 'favicon-';

const SIZES_MAP = {
    16: 'favicon-16x16',
    32: 'favicon-32x32',
    60: 'apple-touch-icon-60x60',
    76: 'apple-touch-icon-76x76',
    120: 'apple-touch-icon-120x120',
    152: 'apple-touch-icon-152x152',
    180: 'apple-touch-icon-180x180',
    192: 'android-chrome-192x192',
    512: 'android-chrome-512x512',
};

const FILES_TO_COPY = {
    'apple-touch-icon-180x180': 'apple-touch-icon',
};

const ICO_SIZES = [16, 24, 32, 48, 64];

const OPTIONS = {
    favicon: {
        name: INTERMEDIATE_FILENAME,
        sizes: Object.keys(SIZES_MAP),
        ico: ICO_SIZES
    }
};

function favIconsTask(callback) {
    if (!fs.existsSync(constants.outputDirectory)) {
        fs.mkdirSync(constants.outputDirectory);
    }

    process.env.OPENSSL_CONF = '';

    iconGen(constants.faviconInputFile, constants.outputDirectory, OPTIONS)
        .then(() => {
            Object.keys(SIZES_MAP).forEach((key) => {
                fs.renameSync(
                    `${constants.outputDirectory}${INTERMEDIATE_FILENAME}${key}${constants.pngExtension}`,
                    `${constants.outputDirectory}${SIZES_MAP[key]}${constants.pngExtension}`
                );
            });

            Object.keys(FILES_TO_COPY).forEach((key) => {
                fs.copyFileSync(
                    `${constants.outputDirectory}${key}${constants.pngExtension}`,
                    `${constants.outputDirectory}${FILES_TO_COPY[key]}${constants.pngExtension}`
                );
            });
        })
        .catch((err) => {
            console.error(err);
        });

    callback();
}

module.exports = favIconsTask;
