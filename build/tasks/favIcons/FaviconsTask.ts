import * as fs from 'fs';
import BuildConstants from '../../BuildConstants';
import AbstractTask from '../../../lib/build/classes/AbstractTask';

const iconGen = require('icon-gen');

interface PngSize {
    size: number;
    output: string;
}

class FaviconsTask extends AbstractTask {
    public readonly name: string = 'Favicons';

    public readonly isAsync: boolean = true;

    private readonly pngMap: PngSize[] = [
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

    private readonly filesToCopy = [
        { input: 'apple-touch-icon-180x180', output: BuildConstants.appleIconPrefix },
    ];

    private readonly icoSizes = [16, 24, 32, 48, 64];

    private readonly options = {
        favicon: {
            name: BuildConstants.faviconPrefix,
            sizes: FaviconsTask.getUniqueSizes(this.pngMap),
        },
        ico: {
            name: BuildConstants.faviconPrefix,
            sizes: this.icoSizes,
        },
    };

    public run(): Promise<void> {
        process.env.OPENSSL_CONF = '';

        return iconGen(
            BuildConstants.faviconInputFile,
            BuildConstants.outputDirectory,
            this.options,
        ).then(() => {
            this.pngMap.forEach((size) => {
                const source = FaviconsTask.buildFilePath(
                    `${BuildConstants.faviconPrefix}${size.size}`,
                );

                const destination = FaviconsTask.buildFilePath(size.output);

                fs.renameSync(source, destination);
            });

            this.filesToCopy.forEach((toCopy) => {
                fs.copyFileSync(
                    FaviconsTask.buildFilePath(toCopy.input),
                    FaviconsTask.buildFilePath(toCopy.output),
                );
            });
        });
    }

    private static buildFilePath(path: string): string {
        return `${BuildConstants.outputDirectory}${path}.png`;
    }

    private static getUniqueSizes(sizesArray: PngSize[]): number[] {
        const sizes = sizesArray.map((size) => size.size);

        return sizes.filter((value, index) => sizes.indexOf(value) === index);
    }
}

export default FaviconsTask;
