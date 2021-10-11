import * as fs from 'fs';
import BuildConstants from '../buildConstants';
import promiseInOrder from '../../lib/promise/inOrder';
import { PromiseRejectFn, PromiseResolveFn } from '../../lib/build/types/PromiseRejectResolve';

const basicCopyTask = (
    resolve: PromiseResolveFn,
    reject: PromiseRejectFn,
    source: string,
    destination: string,
) => {
    fs.promises.readdir(source)
        .then((files) => {
            fs.promises.mkdir(destination)
                .catch(() => {})
                .then(() => {
                    const promiseFunction = (previous: Promise<void>, next: string): any => {
                        const copySource = `${source}${next}`;
                        const copyDest = `${destination}${next}`;

                        return fs.promises.copyFile(copySource, copyDest)
                            .catch((copyFileError) => reject(copyFileError));
                    };

                    promiseInOrder(files, promiseFunction)
                        .then(resolve);
                });
        })
        .catch((readDirError) => reject(readDirError));
};

export const fonts = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => {
    basicCopyTask(
        resolve,
        reject,
        BuildConstants.fontInputDirectory,
        BuildConstants.fontOutputDirectory,
    );
};

export const images = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => {
    basicCopyTask(
        resolve,
        reject,
        BuildConstants.svgInputDirectory,
        BuildConstants.imgOutputDirectory,
    );
};
