import h, { FunctionComponent } from '../../../lib/tsx/TsxParser';

export interface LinkProps {
    href: string;
    title: string;
}

const Link: FunctionComponent<LinkProps> = (props: LinkProps) => {
    const { href, title } = props;

    return (
        <a href={href} title={title} target="_blank" rel="noopener">
            {title}
        </a>
    );
};

interface HeaderProps {
    firstName: string;
    lastName: string;
    links: LinkProps[];
}

export const Header: FunctionComponent<HeaderProps> = (props: HeaderProps) => {
    const { firstName, lastName, links } = props;

    const linkElements = links.map((link: LinkProps) => (
        <Link href={link.href} title={link.title} />
    ));

    return (
        <header>
            <div className="top-avatar" />

            <h1>
                {firstName} <strong>{lastName}</strong>
            </h1>

            <nav>{linkElements.join('')}</nav>
        </header>
    );
};
