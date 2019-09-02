const buildConstants = require('../../buildConstants');
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

module.exports = function favIconsTask(callback) {
    if (!fs.existsSync(buildConstants.outputDirectory)) {
        fs.mkdirSync(buildConstants.outputDirectory);
    }

    process.env.OPENSSL_CONF = '';

    iconGen(buildConstants.faviconInputFile, buildConstants.outputDirectory, OPTIONS)
        .then(() => {
            Object.keys(SIZES_MAP).forEach((key) => {
                fs.renameSync(
                    `${buildConstants.outputDirectory}${INTERMEDIATE_FILENAME}${key}${buildConstants.pngExtension}`,
                    `${buildConstants.outputDirectory}${SIZES_MAP[key]}${buildConstants.pngExtension}`
                );
            });

            Object.keys(FILES_TO_COPY).forEach((key) => {
                fs.copyFileSync(
                    `${buildConstants.outputDirectory}${key}${buildConstants.pngExtension}`,
                    `${buildConstants.outputDirectory}${FILES_TO_COPY[key]}${buildConstants.pngExtension}`
                );
            });
        })
        .catch((err) => {
            console.error(err);
        });

    callback();
};
