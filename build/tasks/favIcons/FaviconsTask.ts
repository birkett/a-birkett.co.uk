import * as fs from 'fs';
import iconGen from 'icon-gen';
import BuildConstants from '../../BuildConstants';
import AbstractTask from '../../../lib/build/classes/AbstractTask';

interface PngSize {
    size: number;
    output: string;
}

class FaviconsTask extends AbstractTask {
    public readonly name: string = 'Favicons';

    public readonly isAsync: boolean = true;

    private readonly pngMap: PngSize[] = [
        { size: 32, output: `${BuildConstants.faviconPrefix}-32x32` },
        { size: 57, output: `${BuildConstants.faviconPrefix}-57x57` },
        { size: 72, output: `${BuildConstants.faviconPrefix}-72x72` },
        { size: 96, output: `${BuildConstants.faviconPrefix}-96x96` },
        { size: 120, output: `${BuildConstants.faviconPrefix}-120x120` },
        { size: 128, output: `${BuildConstants.faviconPrefix}-128x128` },
        { size: 144, output: `${BuildConstants.faviconPrefix}-144x144` },
        { size: 152, output: `${BuildConstants.faviconPrefix}-152x152` },
        { size: 195, output: `${BuildConstants.faviconPrefix}-195x195` },
        { size: 228, output: `${BuildConstants.faviconPrefix}-228x228` },
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
        report: false,
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
