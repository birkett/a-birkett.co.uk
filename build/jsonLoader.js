const buildConstants = require('./buildConstants');
const fs = require('fs');

module.exports = class JsonLoader {
    static loadJson (path) {
        return JSON.parse(fs.readFileSync(path).toString());
    }

    static loadTemplateConstants () {
        return JsonLoader.loadJson(buildConstants.templateConstantsJsonPath);
    }

    static loadIcons () {
        return JsonLoader.loadJson(buildConstants.headerIconsJsonPath);
    }

    static loadTags () {
        return JsonLoader.loadJson(buildConstants.tagsJsonPath);
    }
};
