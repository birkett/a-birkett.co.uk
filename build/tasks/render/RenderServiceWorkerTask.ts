import * as fs from 'fs';
import * as path from 'path';
import { BuildConstants } from '@build/BuildConstants';
import { AbstractRenderTask } from '@build/tasks/render/AbstractRenderTask';

export class RenderServiceWorkerTask extends AbstractRenderTask {
    public readonly name: string = 'Render Service Worker';

    public run(): void {
        const files = RenderServiceWorkerTask.getFiles(BuildConstants.outputDirectory);

        this.renderFile(
            BuildConstants.serviceWorkerInputFileName,
            BuildConstants.serviceWorkerOutputPath,
            { files },
        );
    }

    private static getFiles(baseDirectory: string): string[] {
        const foundFiles: string[] = [];

        const recurseDirectory = (directory: string) => {
            const files = fs.readdirSync(directory);

            files.forEach((file) => {
                const absolute = path.join(directory, file);
                const fileEnt = fs.statSync(absolute);

                return fileEnt.isDirectory()
                    ? recurseDirectory(absolute)
                    : foundFiles.push(absolute);
            });
        };

        recurseDirectory(baseDirectory);

        const trimmedFiles: string[] = [];

        foundFiles.forEach((file) => {
            // Skip over most favicons, the browser should have already cached what it needs.
            if (file.includes('.png')) {
                return;
            }

            const trimmedRootPath = file.substring(file.indexOf('/') + 1);
            const fileName = `${trimmedRootPath}?v=${BuildConstants.gitRevision()}`;

            trimmedFiles.push(fileName);
        });

        return trimmedFiles;
    }
}
