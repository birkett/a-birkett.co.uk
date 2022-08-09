import * as fs from 'fs';
import * as resvg from '@resvg/resvg-js';
import pngToIco from 'png-to-ico';
import { BuildConstants } from '@build/BuildConstants';
import { AbstractTask } from '@build/AbstractTask';

export class FaviconsTask extends AbstractTask {
    public readonly name: string = 'Favicons';

    private readonly pngMap = [
        16, 24, 32, 48, 57, 64, 70, 72, 96, 120, 128, 144, 150, 152, 180, 192, 228, 512,
    ];

    private readonly icoSizes = [16, 24, 32, 48, 64];

    public run(): void {
        this.renderPngs();
        this.renderIco();
    }

    private renderPngs(): void {
        const svg = fs.readFileSync(BuildConstants.faviconInputFile);

        this.pngMap.forEach((size) => {
            const parser = new resvg.Resvg(svg, {
                fitTo: {
                    mode: 'width',
                    value: size,
                },
                font: {
                    loadSystemFonts: false,
                },
                background: 'rgba(0, 0, 0, 0)',
            });

            const pngBuffer = parser.render().asPng();

            fs.writeFileSync(FaviconsTask.buildFilePath(size), pngBuffer);
        });
    }

    private renderIco(): void {
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

    private static buildFilePath(size: number): string {
        return `${BuildConstants.outputDirectory}${BuildConstants.faviconPrefix}-${size}.png`;
    }
}
