import h from '../../../lib/tsx/TsxParser';

export interface LinkProps {
    href: string;
    title: string;
}

function Link(props: Partial<LinkProps>): JSX.Element {
    const { href, title } = props as LinkProps;

    return (
        <a href={href} title={title} target="_blank" rel="noopener">
            {title}
        </a>
    );
}

interface HeaderProps {
    firstName: string;
    lastName: string;
    links: LinkProps[];
}

export function Header(props: Partial<HeaderProps>): JSX.Element {
    const { firstName, lastName, links } = props as HeaderProps;

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
}
