import h, { FunctionComponent } from '../../../lib/tsx/TsxParser';
import { Link } from './Link';

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

    const linkElement = <Link href={href} title={title} content={title} style={style} />;

    const element = href ? linkElement : title;

    return (
        <li>
            <span style={style}>{element}</span>
        </li>
    );
};

interface TagCloudGroupProps {
    title: string;
    tags: TagProps[];
}

const TagCloudGroup: FunctionComponent<TagCloudGroupProps> = (props: TagCloudGroupProps) => {
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

interface TagCloudProps {
    firstName: string;
    tagGroups: TagGroups;
}

export const TagCloud: FunctionComponent<TagCloudProps> = (props: TagCloudProps) => {
    const { firstName, tagGroups } = props;

    const groups = Object.keys(tagGroups).map((group) => (
        <TagCloudGroup title={group} tags={tagGroups[group]} />
    ));

    return (
        <section>
            <h2>{firstName} in words</h2>
            {groups.join('')}
        </section>
    );
};
