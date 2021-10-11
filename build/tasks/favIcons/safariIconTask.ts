import * as fs from 'fs';
import BuildConstants from '../../buildConstants';
import { PromiseResolveFn, PromiseRejectFn } from '../../../lib/build/types/PromiseRejectResolve';

const safariIconTask = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => {
    fs.promises
        .readFile(BuildConstants.faviconInputFile)
        .then((data) => {
            const replaceRegex = new RegExp('fill="#(.*?)"', 'g');

            return data.toString().replace(replaceRegex, 'fill="#000000"');
        })
        .then((outputData) => {
            fs.promises
                .writeFile(BuildConstants.safariIconOutputFileName, outputData)
                .then(resolve)
                .catch((writeFileError) => reject(writeFileError));
        })
        .catch((readFileError) => reject(readFileError));
};

export default safariIconTask;
