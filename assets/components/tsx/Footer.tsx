import h from '../../../lib/tsx/TsxParser';

interface FooterProps {
    firstName: string;
    lastName: string;
    gitRevision: string;
    githubLink: string;
}

function Footer(props: Partial<FooterProps>): JSX.Element {
    const { firstName, lastName, gitRevision, githubLink } = props as FooterProps;

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
}

export default Footer;
