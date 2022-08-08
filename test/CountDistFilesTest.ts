import * as fs from 'fs';
import { BuildConstants } from '../build/BuildConstants';
import { describe, it, suite } from '../lib/test/TestSystem';
import { expect } from '../lib/test/src/Expect';

const EXPECTED_TOTAL_FILES_IN_ROOT = 25;

const testFilesPresent = (
    folder: string,
    extension: string,
    expectedTotal: number,
    expectedMatches: number,
): void => {
    const dirEntries = fs.readdirSync(folder, { withFileTypes: true });

    const allFiles = dirEntries.filter((entry) => entry.isFile());

    expect(allFiles.length).equal(expectedTotal);

    const matches = allFiles.filter((file) => file.name.endsWith(extension));

    expect(matches.length).equal(expectedMatches);
};

suite('Count files in the dist folder', () => {
    describe('CSS', () => {
        it('Should have 1 compiled style sheet', () => {
            testFilesPresent(BuildConstants.cssOutputDirectory, '.css', 1, 1);
        });
    });

    describe('Fonts', () => {
        it('Should have 1 font', () => {
            testFilesPresent(BuildConstants.fontOutputDirectory, '.woff2', 1, 1);
        });
    });

    describe('Images', () => {
        it('Should have 3 SVG images', () => {
            testFilesPresent(BuildConstants.imgOutputDirectory, '.svg', 3, 3);
        });
    });

    describe('JS', () => {
        it('Should have 2 JS files', () => {
            testFilesPresent(
                BuildConstants.outputDirectory,
                '.js',
                EXPECTED_TOTAL_FILES_IN_ROOT,
                2,
            );
        });
    });

    describe('Favicons', () => {
        it('Should have 18 PNG favicons', () => {
            testFilesPresent(
                BuildConstants.outputDirectory,
                '.png',
                EXPECTED_TOTAL_FILES_IN_ROOT,
                18,
            );
        });

        it('Should have 1 SVG favicon', () => {
            testFilesPresent(
                BuildConstants.outputDirectory,
                '.svg',
                EXPECTED_TOTAL_FILES_IN_ROOT,
                1,
            );
        });

        it('Should have 1 ICO favicon', () => {
            testFilesPresent(
                BuildConstants.outputDirectory,
                '.ico',
                EXPECTED_TOTAL_FILES_IN_ROOT,
                1,
            );
        });
    });
});
