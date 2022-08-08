import * as fs from 'fs';
import pngToIco from 'png-to-ico';
import svg2img from 'svg2img';
import { BuildConstants } from '@build/BuildConstants';
import { AbstractTask } from '@build/AbstractTask';

export class FaviconsTask extends AbstractTask {
    public readonly name: string = 'Favicons';

    private readonly pngMap = [
        16, 24, 32, 48, 57, 64, 70, 72, 96, 120, 128, 144, 150, 152, 180, 192, 228, 512,
    ];

    private readonly icoSizes = [16, 24, 32, 48, 64];

    public run(): void {
        process.env.OPENSSL_CONF = '';

        this.pngMap.forEach((size, index) => {
            const options = { width: size, height: size };

            svg2img(BuildConstants.faviconInputFile, options, (_, buffer) => {
                fs.writeFileSync(FaviconsTask.buildFilePath(size), buffer);

                if (index === this.pngMap.length - 1) {
                    const icoFileNames: string[] = [];

                    this.icoSizes.forEach((icoSize) => {
                        icoFileNames.push(FaviconsTask.buildFilePath(icoSize));
                    });

                    pngToIco(icoFileNames).then((output) => {
                        fs.writeFileSync(
                            `${BuildConstants.outputDirectory}${BuildConstants.faviconPrefix}.ico`,
                            output,
                        );
                    });
                }
            });
        });
    }

    private static buildFilePath(size: number): string {
        return `${BuildConstants.outputDirectory}${BuildConstants.faviconPrefix}-${size}.png`;
    }
}
