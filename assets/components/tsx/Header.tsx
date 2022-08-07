import h, { FunctionComponent } from '../../../lib/tsx/TsxParser';
import { Link, LinkProps } from './Link';

interface HeaderProps {
    firstName: string;
    lastName: string;
    links: LinkProps[];
}

export const Header: FunctionComponent<HeaderProps> = (props: HeaderProps) => {
    const { firstName, lastName, links } = props;

    const linkElements = links.map((link: LinkProps) => (
        <Link href={link.href} title={link.title} content={link.title} />
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
