import h from '../../../lib/tsx/TsxParser';

interface TagProps {
    title: string;
    href?: string;
    textColor: string;
    bgColor: string;
}

function Tag(props: Partial<TagProps>): JSX.Element {
    const { title, href, textColor, bgColor } = props as TagProps;

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
}

interface TagCloudContentProps {
    title: string;
    tags: TagProps[];
}

export function TagCloudContent(props: Partial<TagCloudContentProps>): JSX.Element {
    const { tags, title } = props as TagCloudContentProps;

    const tagElements = tags.map((tag: TagProps) => (
        <Tag title={tag.title} href={tag.href} bgColor={tag.bgColor} textColor={tag.textColor} />
    ));

    return (
        <div className="tag-cloud">
            <h3>{title}</h3>
            <ul>{tagElements.join('')}</ul>
        </div>
    );
}

export interface TagGroups {
    [key: string]: TagProps[];
}

export interface TagCloudProps extends TagCloudContentProps {
    firstName: string;
    tagGroups: TagGroups;
}

function TagCloud(props: Partial<TagCloudProps>): JSX.Element {
    const { firstName, tagGroups } = props as TagCloudProps;

    const elements = Object.keys(tagGroups).map((group) => (
        <TagCloudContent title={group} tags={tagGroups[group]} />
    ));

    return (
        <section>
            <h2>{firstName} in words</h2>
            {elements.join('')}
        </section>
    );
}

export default TagCloud;
