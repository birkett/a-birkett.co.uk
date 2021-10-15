import * as fs from 'fs';
import iconGen from 'icon-gen';
import svg2img from 'svg2img';
import BuildConstants from '../../BuildConstants';
import AbstractTask from '../../../lib/build/classes/AbstractTask';

class FaviconsTask extends AbstractTask {
    public readonly name: string = 'Favicons';

    public readonly isAsync: boolean = true;

    private readonly pngMap = [32, 57, 70, 72, 96, 120, 128, 144, 150, 152, 180, 192, 228, 512];

    private readonly icoSizes = [16, 24, 32, 48, 64];

    private readonly options = {
        ico: {
            name: BuildConstants.faviconPrefix,
            sizes: this.icoSizes,
        },
        report: false,
    };

    public run(): Promise<void> {
        process.env.OPENSSL_CONF = '';

        this.pngMap.forEach((size) => {
            const options = { width: size, height: size };

            svg2img(BuildConstants.faviconInputFile, options, (error, buffer) => {
                fs.writeFileSync(FaviconsTask.buildFilePath(size), buffer);
            });
        });

        return iconGen(
            BuildConstants.faviconInputFile,
            BuildConstants.outputDirectory,
            this.options,
        ).then(() => {});
    }

    private static buildFilePath(size: number): string {
        return `${BuildConstants.outputDirectory}${BuildConstants.faviconPrefix}-${size}.png`;
    }
}

export default FaviconsTask;
