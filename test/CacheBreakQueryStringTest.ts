import * as fs from 'fs';
import BuildConstants from '../build/buildConstants';
import { describe, it, suite } from '../lib/test/TestSystem';
import expect from '../lib/test/src/Expect';

const VERSION_QUERY_STRING_REGEX = /\?v=(\w{0,7})/g; // ?v=...
const URL_TAG_REGEX = /url\(([^)]+)\)/g; // Selects url(...) tags from CSS.
const XML_SRC_ATTRIBUTE_REGEX = /src="([^"]+)"/g; // Selects src="..." attributes from XML.
const JSON_SRC_PROPERTY_REGEX = /src": "([^"]+)"/g; // Selects src: "..." properties from JSON.

const genericVersionStringTest = (filename: string, regex: RegExp) => {
    const fileContent = fs.readFileSync(filename);
    const expectedRevisionHash = BuildConstants.gitRevision();
    const matches = fileContent.toString().match(regex);

    expect(matches && matches.length > 0).equal(true);

    // The string should contain the valid git hash.
    matches!.forEach((match) => {
        expect(match.includes(`?v=${expectedRevisionHash}`)).equal(true);
    });
};

const versionQueryStringTest = (filename: string) => {
    genericVersionStringTest(filename, VERSION_QUERY_STRING_REGEX);
};

const urlResourceTest = (filename: string) => {
    genericVersionStringTest(filename, URL_TAG_REGEX);
};

const xmlSrcAttributeTest = (filename: string) => {
    genericVersionStringTest(filename, XML_SRC_ATTRIBUTE_REGEX);
};

const jsonSrcPropertyTest = (filename: string) => {
    genericVersionStringTest(filename, JSON_SRC_PROPERTY_REGEX);
};

suite('Cache breaker query strings', () => {
    describe('CSS', () => {
        it('Should contain valid cache break query strings on referenced resources', () => {
            versionQueryStringTest(
                `${BuildConstants.cssOutputDirectory}${BuildConstants.outputCssFileName}`,
            );
        });

        it('All URL references should contains cache break query strings', () => {
            urlResourceTest(
                `${BuildConstants.cssOutputDirectory}${BuildConstants.outputCssFileName}`,
            );
        });
    });

    describe('HTML', () => {
        it('Should contain valid cache break query strings on referenced resources', () => {
            versionQueryStringTest(BuildConstants.templateOutputFileName);
        });
    });

    describe('Browser Config', () => {
        it('Should contain valid cache break query strings on referenced resources', () => {
            versionQueryStringTest(BuildConstants.browserConfigOutputFileName);
        });

        it('All SRC attributes should contain cache break query strings', () => {
            xmlSrcAttributeTest(BuildConstants.browserConfigOutputFileName);
        });
    });

    describe('Web Manifest', () => {
        it('Should contain valid cache break query strings on referenced resources', () => {
            versionQueryStringTest(BuildConstants.webManifestOutputFileName);
        });

        it('All SRC properties should contain cache break query strings', () => {
            jsonSrcPropertyTest(BuildConstants.webManifestOutputFileName);
        });
    });
});
