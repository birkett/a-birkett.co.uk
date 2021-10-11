import * as fs from 'fs';
import BuildConstants from '../../buildConstants';
import { PromiseRejectFn, PromiseResolveFn } from '../../../lib/build/types/PromiseRejectResolve';

interface PngSize {
    size: number;
    output: string;
}

const iconGen = require('icon-gen');

const PNG_MAP: PngSize[] = [
    { size: 16, output: `${BuildConstants.faviconPrefix}-16x16` },
    { size: 32, output: `${BuildConstants.faviconPrefix}-32x32` },
    { size: 60, output: `${BuildConstants.appleIconPrefix}-60x60` },
    { size: 70, output: `${BuildConstants.msTileIconPrefix}-70x70` },
    { size: 76, output: `${BuildConstants.appleIconPrefix}-76x76` },
    { size: 120, output: `${BuildConstants.appleIconPrefix}-120x120` },
    { size: 144, output: `${BuildConstants.msTileIconPrefix}-144x144` },
    { size: 150, output: `${BuildConstants.msTileIconPrefix}-150x150` },
    { size: 152, output: `${BuildConstants.appleIconPrefix}-152x152` },
    { size: 180, output: `${BuildConstants.appleIconPrefix}-180x180` },
    { size: 192, output: `${BuildConstants.androidIconPrefix}-192x192` },
    { size: 310, output: `${BuildConstants.msTileIconPrefix}-310x310` },
    { size: 512, output: `${BuildConstants.androidIconPrefix}-512x512` },
];

const FILES_TO_COPY = [
    { input: 'apple-touch-icon-180x180', output: BuildConstants.appleIconPrefix },
];

const getUniqueSizes = (sizesArray: PngSize[]) => {
    const sizes = sizesArray.map((size) => size.size);

    return sizes.filter((value, index) => sizes.indexOf(value) === index);
};

const ICO_SIZES = [16, 24, 32, 48, 64];

const OPTIONS = {
    favicon: {
        name: BuildConstants.faviconPrefix,
        sizes: getUniqueSizes(PNG_MAP),
    },
    ico: {
        name: BuildConstants.faviconPrefix,
        sizes: ICO_SIZES,
    },
};

const favIconsTask = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => {
    process.env.OPENSSL_CONF = '';

    const buildFilePath = (path: string) => `${BuildConstants.outputDirectory}${path}.png`;

    iconGen(BuildConstants.faviconInputFile, BuildConstants.outputDirectory, OPTIONS)
        .then(() => {
            PNG_MAP.forEach((size) => {
                const source = buildFilePath(`${BuildConstants.faviconPrefix}${size.size}`);
                const destination = buildFilePath(size.output);

                fs.promises.rename(source, destination).catch((renameError) => reject(renameError));
            });
        })
        .then(() => {
            FILES_TO_COPY.forEach((toCopy) => {
                fs.promises
                    .copyFile(buildFilePath(toCopy.input), buildFilePath(toCopy.output))
                    .catch((copyError) => reject(copyError));
            });
        })
        .then(resolve);
};

export default favIconsTask;
