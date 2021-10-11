import * as fs from 'fs';
import * as util from 'util';
import BuildConstants from '../buildConstants';
import { PromiseRejectFn, PromiseResolveFn } from '../../lib/build/types/PromiseRejectResolve';

const nunjucks = require('nunjucks');

const loadJson = (path: string) => JSON.parse(fs.readFileSync(path).toString());

export const basicRenderTask = (
    resolve: PromiseResolveFn,
    reject: PromiseRejectFn,
    source: string,
    destination: string,
    additionalData?: {},
) => {
    const data = {
        constants: {
            ...loadJson(BuildConstants.templateConstantsJsonPath),
            ...BuildConstants,
        },
        ...additionalData,
    };

    util.promisify(nunjucks.render)(source, data)
        .then((renderedTemplate: string) => {
            fs.promises
                .writeFile(destination, renderedTemplate)
                .then(resolve)
                .catch((writeFileError) => reject(writeFileError));
        })
        .catch((renderFileError: string) => reject(renderFileError));
};

export const browserConfig = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => {
    basicRenderTask(
        resolve,
        reject,
        BuildConstants.browserConfigInputFileName,
        BuildConstants.browserConfigOutputFileName,
    );
};

export const indexTemplate = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => {
    basicRenderTask(
        resolve,
        reject,
        BuildConstants.templateInputFileName,
        BuildConstants.templateOutputFileName,
        {
            links: loadJson(BuildConstants.headerLinksJsonPath),
            tagGroups: loadJson(BuildConstants.tagsJsonPath),
        },
    );
};

export const webManifest = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => {
    basicRenderTask(
        resolve,
        reject,
        BuildConstants.webManifestInputFileName,
        BuildConstants.webManifestOutputFileName,
    );
};
