import h, { FunctionComponent } from '@tsx/TsxParser';

export interface LinkProps {
    href?: string;
    title: string;
    style?: Record<string, string>;
}

export const Link: FunctionComponent<LinkProps> = (props: LinkProps) => {
    const { href, title, style } = props;

    return (
        <a href={href || '#'} style={style || {}} target="_blank" rel="noopener">
            {title}
        </a>
    );
};
