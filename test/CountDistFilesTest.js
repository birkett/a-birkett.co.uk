const fs = require('fs');
const buildConstants = require('../build/buildConstants');
const {
    describe,
    expect,
    it,
    suite,
} = require('../lib/test/testSystem');

const testFilesPresent = (folder, extension, expectedTotal, expectedMatches) => {
    const dirEntries = fs.readdirSync(folder, { withFileTypes: true });

    const allFiles = dirEntries.filter((entry) => entry.isFile());

    expect(allFiles.length).equal(expectedTotal);

    const matches = allFiles.filter((file) => file.name.endsWith(extension));

    expect(matches.length).equal(expectedMatches);
};

suite('Count files in the dist folder', () => {
    describe('CSS', () => {
        it('Should have 1 compiled style sheet', () => {
            testFilesPresent(buildConstants.cssOutputDirectory, '.css', 1, 1);
        });
    });

    describe('Fonts', () => {
        it('Should have 1 font', () => {
            testFilesPresent(buildConstants.fontOutputDirectory, '.woff2', 1, 1);
        });
    });

    describe('Images', () => {
        it('Should have 3 SVG images', () => {
            testFilesPresent(buildConstants.imgOutputDirectory, '.svg', 3, 3);
        });
    });

    describe('JS', () => {
        it('Should have 1 JS file', () => {
            testFilesPresent(buildConstants.outputDirectory, '.js', 20, 1);
        });
    });

    describe('Favicons', () => {
        it('Should have 14 PNG favicons', () => {
            testFilesPresent(buildConstants.outputDirectory, '.png', 20, 14);
        });

        it('Should have 1 SVG favicon', () => {
            testFilesPresent(buildConstants.outputDirectory, '.svg', 20, 1);
        });

        it('Should have 1 ICO favicon', () => {
            testFilesPresent(buildConstants.outputDirectory, '.ico', 20, 1);
        });
    });
});
