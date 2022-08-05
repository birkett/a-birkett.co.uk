import h from '../../../lib/tsx/TsxParser';

interface TagCloudTitleProps {
    firstName: string;
}

export function TagCloudTitle(props: Partial<TagCloudTitleProps>): JSX.Element {
    const { firstName } = props as TagCloudTitleProps;

    return <h2>{firstName} in words</h2>;
}

interface TagProps {
    title: string;
    url?: string;
    textColor: string;
    bgColor: string;
}

function Tag(props: Partial<TagProps>): JSX.Element {
    const { title, url, textColor, bgColor } = props as TagProps;

    const style = {
        color: textColor,
        backgroundColor: bgColor,
    };

    return (
        <li>
            <span style={style}>
                props.url &&{' '}
                <a href={url} target="_blank" rel="noopener" style={style}>
                    {title}
                    props.utl &&{' '}
                </a>
            </span>
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
        <Tag title={tag.title} url={tag.url} bgColor={tag.bgColor} textColor={tag.textColor} />
    ));

    return (
        <div className="tag-cloud">
            <h3>{title}</h3>
            <ul>{tagElements}</ul>
        </div>
    );
}

export interface TagCloudProps extends TagCloudContentProps {
    firstName: string;
}

function TagCloud(props: Partial<TagCloudProps>): JSX.Element {
    const { firstName, title, tags } = props as TagCloudProps;

    return (
        <section>
            <TagCloudTitle firstName={firstName} />
            <TagCloudContent title={title} tags={tags} />
        </section>
    );
}

export default TagCloud;
