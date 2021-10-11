import * as fs from 'fs';
import * as path from 'path';
import BuildConstants from '../buildConstants';
import { PromiseRejectFn, PromiseResolveFn } from '../../lib/build/types/PromiseRejectResolve';
import { basicRenderTask } from './renderTemplateTask';

const getFiles = (baseDirectory: string) => {
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
};

const serviceWorkerTask = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => {
    const files = getFiles(BuildConstants.outputDirectory);

    basicRenderTask(
        resolve,
        reject,
        BuildConstants.serviceWorkerInputFileName,
        BuildConstants.serviceWorkerOutputFileName,
        { files },
    );
};

export default serviceWorkerTask;
