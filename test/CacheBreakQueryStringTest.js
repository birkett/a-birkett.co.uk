const assert = require('assert');
const fs = require('fs');
const buildConstants = require('../build/buildConstants');

const VERSION_QUERY_STRING_REGEX = /\?v=(\w{0,7})/g; // ?v=...
const URL_TAG_REGEX = /url\(([^)]+)\)/g; // Selects url(...) tags from CSS.
const XML_SRC_ATTRIBUTE_REGEX = /src="([^"]+)"/g; // Selects src="..." attributes from XML.
const JSON_SRC_PROPERTY_REGEX = /src": "([^"]+)"/g; // Selects src: "..." properties from JSON.

const genericVersionStringTest = (filename, regex) => {
    fs.readFile(filename, (err, fileContent) => {
        if (err) {
            throw err;
        }

        const expectedRevisionHash = buildConstants.gitRevision();
        const matches = fileContent.toString().match(regex);

        assert.strictEqual(matches && matches.length > 0, true);

        // The string should contain the valid git hash.
        matches.forEach((match) => {
            assert.strictEqual(match.includes(`?v=${expectedRevisionHash}`), true);
        });
    });
};

const versionQueryStringTest = (filename) => {
    genericVersionStringTest(filename, VERSION_QUERY_STRING_REGEX);
};

const urlResourceTest = (filename) => {
    genericVersionStringTest(filename, URL_TAG_REGEX);
};

const xmlSrcAttributeTest = (filename) => {
    genericVersionStringTest(filename, XML_SRC_ATTRIBUTE_REGEX);
};

const jsonSrcPropertyTest = (filename) => {
    genericVersionStringTest(filename, JSON_SRC_PROPERTY_REGEX);
};

describe('Cache breaker query strings', () => {
    describe('Site Version', () => {
        it('Should contain the current git revision hash', () => {
            assert.strictEqual(buildConstants.siteVersion(), buildConstants.gitRevision());
        });
    });

    describe('CSS', () => {
        it('Should contain valid cache break query strings on referenced resources', () => {
            versionQueryStringTest(
                `${buildConstants.cssOutputDirectory}${buildConstants.outputCssFileName}`,
            );
        });

        it('All URL references should contains cache break query strings', () => {
            urlResourceTest(
                `${buildConstants.cssOutputDirectory}${buildConstants.outputCssFileName}`,
            );
        });
    });

    describe('HTML', () => {
        it('Should contain valid cache break query strings on referenced resources', () => {
            versionQueryStringTest(buildConstants.templateOutputFileName);
        });
    });

    describe('Browser Config', () => {
        it('Should contain valid cache break query strings on referenced resources', () => {
            versionQueryStringTest(buildConstants.browserConfigOutputFileName);
        });

        it('All SRC attributes should contain cache break query strings', () => {
            xmlSrcAttributeTest(buildConstants.browserConfigOutputFileName);
        });
    });

    describe('Web Manifest', () => {
        it('Should contain valid cache break query strings on referenced resources', () => {
            versionQueryStringTest(buildConstants.webManifestOutputFileName);
        });

        it('All SRC properties should contain cache break query strings', () => {
            jsonSrcPropertyTest(buildConstants.webManifestOutputFileName);
        });
    });
});
