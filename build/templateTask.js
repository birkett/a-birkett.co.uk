const constants = require('./constants');
const fs = require('fs');

const TEMPLATE_CONSTANTS_JSON_FILE_NAME = 'constants.json';
const TEMPLATE_INPUT_FILE_NAME = 'base.html';
const TEMPLATE_OUTPUT_FILE_NAME = 'index.html';

const HEADER_ICONS_JSON_FILE_NAME = 'headerIcons.json';
const HEADER_ICON_TEMPLATE_FILE_NAME = 'headerIcon.html';

const TAGS_JSON_FILE_NAME = 'tagCloud.json';
const TAG_TEMPLATE_FILE_NAME = 'tag.html';
const TAG_GROUP_TEMPLATE_FILE_NAME = 'tagGroup.html';

const PARAGRAPHS_JSON_FILE_NAME = 'paragraphs.json';
const PARAGRAPHS_TEMPLATE_FILE_NAME = 'paragraphBlock.html';

const DEFAULT_TAG_COLOR = 'white';
const DEFAULT_TAG_URL = '#';
const DEFAULT_PARAGRAPH_TITLE = '';

function buildIcons() {
    const navIcons = JSON.parse(
        fs.readFileSync(constants.jsonInputDir + HEADER_ICONS_JSON_FILE_NAME).toString()
    );

    const navIconTemplate = fs.readFileSync(constants.componentInputDir + HEADER_ICON_TEMPLATE_FILE_NAME);

    let builtIconsString = '';

    Object.keys(navIcons).forEach(function (key) {
        navIcons[key].forEach(function (icon) {
            let iconString = navIconTemplate.toString();

            iconString = iconString.replace('{{url}}', icon.url);
            iconString = iconString.replace('{{title}}', icon.title);
            iconString = iconString.replace('{{className}}', icon.title.toLowerCase());

            builtIconsString += iconString;
        });
    });

    return builtIconsString;
}

function buildTagsFromGroup(group) {
    const tagTemplate = fs.readFileSync(constants.tagTemplatesInputDir + TAG_TEMPLATE_FILE_NAME);

    let tagsString = '';

    group.forEach(function (tag) {
        let tagString = tagTemplate.toString();

        const tagUrl = tag.url || DEFAULT_TAG_URL;

        tagString = tagString.replace('{{title}}', tag.title);
        tagString = tagString.replace('{{color}}', tag.color || DEFAULT_TAG_COLOR);

        if (tagUrl !== DEFAULT_TAG_URL) {
            tagString = tagString.replace('{{url}}', tagUrl);
            tagString = tagString.replace('{{link_block}}', '');
            tagString = tagString.replace('{{end_link_block}}', '');
        } else {
            const regex = new RegExp('{{link_block}}(.*?){{end_link_block}}', 'g');

            tagString = tagString.replace(regex, '');
        }

        tagsString += tagString;
    });

    return tagsString;
}

function buildTagsGroups() {
    const tags = JSON.parse(
        fs.readFileSync(constants.jsonInputDir + TAGS_JSON_FILE_NAME).toString()
    );

    const tagGroupTemplate = fs.readFileSync(constants.tagTemplatesInputDir + TAG_GROUP_TEMPLATE_FILE_NAME);

    let builtTagsString = '';

    Object.keys(tags).forEach(function (group) {
        let tagGroupString = tagGroupTemplate.toString();

        tagGroupString = tagGroupString.replace('{{groupTitle}}', group);
        tagGroupString = tagGroupString.replace('{{tags}}', buildTagsFromGroup(tags[group]));

        builtTagsString += tagGroupString;
    });

    return builtTagsString;
}

function buildParagraphs() {
    const paragraphs = JSON.parse(
        fs.readFileSync(constants.jsonInputDir + PARAGRAPHS_JSON_FILE_NAME).toString()
    );

    const paragraphTemplate = fs.readFileSync(constants.componentInputDir + PARAGRAPHS_TEMPLATE_FILE_NAME);

    let builtParagraphsString = '';

    Object.keys(paragraphs).forEach(function (key) {
        let paragraphString = '';

        paragraphs[key].forEach(function (item) {
            let paragraph = paragraphTemplate.toString();

            const paragraphTitle = item.title || DEFAULT_PARAGRAPH_TITLE;

            if (paragraphTitle !== DEFAULT_PARAGRAPH_TITLE) {
                paragraph = paragraph.replace('{{title}}', item.title);
                paragraph = paragraph.replace('{{title_block}}', '');
                paragraph = paragraph.replace('{{end_title_block}}', '');
            } else {
                const regex = new RegExp('{{title_block}}(.*?){{end_title_block}}', 'g');

                paragraph = paragraph.replace(regex, '');
            }

            paragraph = paragraph.replace('{{content}}', item.content.join(''));

            paragraphString += paragraph;
        });

        builtParagraphsString += paragraphString;
    });

    return builtParagraphsString;
}

function buildBaseTemplate() {
    const templateConstants = JSON.parse(
        fs.readFileSync(constants.jsonInputDir + TEMPLATE_CONSTANTS_JSON_FILE_NAME).toString()
    );

    const baseTemplate = fs.readFileSync(constants.componentInputDir + TEMPLATE_INPUT_FILE_NAME);

    let baseTemplateString = baseTemplate.toString();

    baseTemplateString = baseTemplateString.replace('{{paragraphs}}', buildParagraphs());
    baseTemplateString = baseTemplateString.replace('{{navIcons}}', buildIcons());
    baseTemplateString = baseTemplateString.replace('{{tagCloud}}', buildTagsGroups());

    templateConstants.firstName = constants.firstName;
    templateConstants.lastName = constants.lastName;
    templateConstants.version = constants.siteVersion;

    Object.keys(templateConstants).forEach(function (key) {
        const regex = new RegExp('{{' + key + '}}', 'g');

        baseTemplateString = baseTemplateString.replace(regex, templateConstants[key]);
    });

    return baseTemplateString;
}

function templateTask(callback) {
    fs.writeFile(
        `${constants.outputDirectory}${TEMPLATE_OUTPUT_FILE_NAME}`,
        buildBaseTemplate(),
        callback
    );
}

module.exports = templateTask;
