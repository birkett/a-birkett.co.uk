import * as fs from 'fs';
import BuildConstants from '../buildConstants';
import { PromiseRejectFn, PromiseResolveFn } from '../../lib/build/types/PromiseRejectResolve';

const cleanTask = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => {
    const recreatedOutputDirectory = (res: PromiseResolveFn, rej: PromiseRejectFn) => {
        fs.promises
            .mkdir(BuildConstants.outputDirectory)
            .then(res)
            .catch((mkdirError) => rej(mkdirError));
    };

    fs.promises
        .stat(BuildConstants.outputDirectory)
        .then(() => {
            fs.promises
                .rmdir(BuildConstants.outputDirectory, { recursive: true })
                .then(() => recreatedOutputDirectory(resolve, reject))
                .catch((rmdirError) => reject(rmdirError));
        })
        .catch(() => {
            recreatedOutputDirectory(resolve, reject);
        });
};

export default cleanTask;
