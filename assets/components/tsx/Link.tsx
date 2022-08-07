import h, { FunctionComponent } from '../../../lib/tsx/TsxParser';

export interface LinkProps {
    href?: string;
    title: string;
    content: string;
    style?: Record<string, string>;
}

export const Link: FunctionComponent<LinkProps> = (props: LinkProps) => {
    const { href, title, content, style } = props;

    return (
        <a href={href || '#'} title={title} style={style || {}} target="_blank" rel="noopener">
            {content}
        </a>
    );
};
