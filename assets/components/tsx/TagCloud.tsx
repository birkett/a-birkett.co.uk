import h, { FunctionComponent } from '../../../lib/tsx/TsxParser';

interface TagProps {
    title: string;
    href?: string;
    textColor: string;
    bgColor: string;
}

const Tag: FunctionComponent<TagProps> = (props: TagProps) => {
    const { title, href, textColor, bgColor } = props;

    const style = {
        color: textColor,
        backgroundColor: bgColor,
    };

    const linkElement = (
        <a href={href} target="_blank" rel="noopener" style={style}>
            {title}
        </a>
    );

    const element = href ? linkElement : title;

    return (
        <li>
            <span style={style}>{element}</span>
        </li>
    );
};

interface TagCloudContentProps {
    title: string;
    tags: TagProps[];
}

const TagCloudContent: FunctionComponent<TagCloudContentProps> = (props: TagCloudContentProps) => {
    const { tags, title } = props;

    const tagElements = tags.map((tag: TagProps) => (
        <Tag title={tag.title} href={tag.href} bgColor={tag.bgColor} textColor={tag.textColor} />
    ));

    return (
        <div className="tag-cloud">
            <h3>{title}</h3>
            <ul>{tagElements.join('')}</ul>
        </div>
    );
};

export interface TagGroups {
    [key: string]: TagProps[];
}

export interface TagCloudProps {
    firstName: string;
    tagGroups: TagGroups;
}

const TagCloud: FunctionComponent<TagCloudProps> = (props: TagCloudProps) => {
    const { firstName, tagGroups } = props;

    const elements = Object.keys(tagGroups).map((group) => (
        <TagCloudContent title={group} tags={tagGroups[group]} />
    ));

    return (
        <section>
            <h2>{firstName} in words</h2>
            {elements.join('')}
        </section>
    );
};

export default TagCloud;
