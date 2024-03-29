import h, { FunctionComponent } from '@tsx/TsxParser';
import { Link, LinkProps } from '@components/Link';
import { ElementArray } from '@tsx/ElementArray';

interface HeaderProps {
    firstName: string;
    lastName: string;
    links: LinkProps[];
}

export const Header: FunctionComponent<HeaderProps> = (props: HeaderProps) => {
    const { firstName, lastName, links } = props;

    const linkElements = new ElementArray<JSX.Element>();

    links.forEach((link: LinkProps) => {
        linkElements.push(<Link href={link.href} title={link.title} />);
    });

    return (
        <header>
            <div className="top-avatar" />

            <h1>
                {firstName} <strong>{lastName}</strong>
            </h1>

            <nav>{linkElements}</nav>
        </header>
    );
};
