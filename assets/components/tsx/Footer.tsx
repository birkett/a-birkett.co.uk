import h, { FunctionComponent } from '../../../lib/tsx/TsxParser';

interface FooterProps {
    firstName: string;
    lastName: string;
    gitRevision: string;
    githubLink: string;
}

const Footer: FunctionComponent<FooterProps> = (props: FooterProps) => {
    const { firstName, lastName, gitRevision, githubLink } = props;

    return (
        <footer>
            <p>
                &copy; {firstName} {lastName}
            </p>
            <p>
                This site is Open Source. Current revision {gitRevision}.
                <a href={githubLink} target="_blank" rel="noopener">
                    Code available on GitHub.
                </a>
            </p>
        </footer>
    );
};

export default Footer;
