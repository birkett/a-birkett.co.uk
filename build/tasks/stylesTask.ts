import * as fs from 'fs';
import * as util from 'util';
import BuildConstants from '../buildConstants';
import { PromiseRejectFn, PromiseResolveFn } from '../../lib/build/types/PromiseRejectResolve';

const sass = require('sass');

const stylesTask = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => {
    fs.promises
        .readFile(`${BuildConstants.scssInputDirectory}main.scss`)
        .then((scss) => {
            const sassOptions = {
                outputStyle: 'compressed',
                includePaths: [BuildConstants.scssInputDirectory],
                data: `$gitRevision: '${BuildConstants.gitRevision()}'; ${scss}`,
            };

            return util.promisify(sass.render)(sassOptions);
        })
        .then((renderResult) => {
            fs.promises.mkdir(BuildConstants.cssOutputDirectory).catch(() => {});

            return renderResult.css.toString();
        })
        .then((css) => {
            fs.promises
                .writeFile(`${BuildConstants.cssOutputDirectory}main.css`, css)
                .then(resolve)
                .catch((writeFileError) => reject(writeFileError));
        })
        .catch((readFileError) => reject(readFileError));
};

export default stylesTask;
