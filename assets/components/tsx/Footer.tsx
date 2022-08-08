import h, { FunctionComponent } from '../../../lib/tsx/TsxParser';
import { Link } from './Link';

interface FooterProps {
    firstName: string;
    lastName: string;
    gitRevision: string;
    githubLink: string;
}

export const Footer: FunctionComponent<FooterProps> = (props: FooterProps) => {
    const { firstName, lastName, gitRevision, githubLink } = props;

    return (
        <footer>
            <p>
                &copy; {firstName} {lastName}
            </p>
            <p>
                This site is Open Source. Current revision {gitRevision}.&nbsp;
                <Link href={githubLink} title="Code available on GitHub." />
            </p>
        </footer>
    );
};
