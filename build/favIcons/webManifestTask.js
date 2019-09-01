const constants = require('../constants');
const fs = require('fs');

const WEB_MANIFEST_FILE_NAME = 'site.webmanifest';

const WEB_MANIFEST = {
    "name": `${constants.firstName} ${constants.lastName}`,
    "short_name": `${constants.firstName} ${constants.lastName}`,
    "icons": [
        {
            "src": `android-chrome-192x192${constants.pngExtension}?v=${constants.siteVersion}`,
            "sizes": "192x192",
            "type": "image/png"
        },
        {
            "src": `android-chrome-512x512${constants.pngExtension}?v=${constants.siteVersion}`,
            "sizes": "512x512",
            "type": "image/png"
        }
    ],
    "theme_color": "#FFFFFF",
    "background_color": "#FFFFFF"
};

function webManifestTask(callback) {
    fs.writeFileSync(
        `${constants.outputDirectory}${WEB_MANIFEST_FILE_NAME}`,
        JSON.stringify(WEB_MANIFEST)
    );

    callback();
}

module.exports = webManifestTask;
