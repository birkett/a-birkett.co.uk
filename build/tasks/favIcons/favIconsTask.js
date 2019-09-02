const buildConstants = require('../../buildConstants');
const fs = require('fs');
const iconGen = require('icon-gen');

const SIZES_MAP = {
    16: buildConstants.faviconPrefix + '-16x16',
    32: buildConstants.faviconPrefix + '-32x32',
    60: buildConstants.appleIconPrefix + '-60x60',
    70: buildConstants.msTileIconPrefix + '-70x70',
    76: buildConstants.appleIconPrefix + '-76x76',
    120: buildConstants.appleIconPrefix + '-120x120',
    144: buildConstants.msTileIconPrefix + '-144x144',
    150: buildConstants.msTileIconPrefix + '-150x150',
    152: buildConstants.appleIconPrefix + '-152x152',
    180: buildConstants.appleIconPrefix + '-180x180',
    192: buildConstants.androidIconPrefix + '-192x192',
    310: buildConstants.msTileIconPrefix + '-310x310',
    512: buildConstants.androidIconPrefix + '-512x512',
};

const FILES_TO_COPY = {
    'apple-touch-icon-180x180': buildConstants.appleIconPrefix,
};

const ICO_SIZES = [16, 24, 32, 48, 64];

const OPTIONS = {
    favicon: {
        name: buildConstants.faviconPrefix,
        sizes: Object.keys(SIZES_MAP),
    },
    ico: {
        name: buildConstants.faviconPrefix,
        sizes: ICO_SIZES
    },
};

function buildFilePath(path) {
    return buildConstants.outputDirectory + path + buildConstants.pngExtension;
}

module.exports = function favIconsTask(callback) {
    process.env.OPENSSL_CONF = '';

    iconGen(buildConstants.faviconInputFile, buildConstants.outputDirectory, OPTIONS)
        .then(() => {
            Object.keys(SIZES_MAP).forEach((key) => {
                fs.renameSync(
                    buildFilePath(buildConstants.faviconPrefix + key),
                    buildFilePath(SIZES_MAP[key])
                );
            });

            Object.keys(FILES_TO_COPY).forEach((key) => {
                fs.copyFileSync(
                    buildFilePath(key),
                    buildFilePath(FILES_TO_COPY[key])
                );
            });

            callback();
        })
        .catch((err) => {
            console.error(err);
        });
};
