import h from '../../../lib/tsx/TsxParser';
import Footer from './Footer';
import { Header, LinkProps } from './Header';
import About from './About';
import TagCloud, { TagGroups } from './TagCloud';
import HeadMeta from './HeadMeta';

export interface BaseProps {
    firstName: string;
    lastName: string;
    gitRevision: string;
    githubLink: string;
    links: LinkProps[];
    msTileColor: string;
    faviconPrefix: string;
    themeColor: string;
    webManifestFileName: string;
    safariIconFileName: string;
    fontFileName: string;
    outputCssFileName: string;
    baseUrl: string;
    tagGroups: TagGroups;
}

function Base(props: Partial<BaseProps>): JSX.Element {
    const {
        firstName,
        lastName,
        gitRevision,
        githubLink,
        links,
        msTileColor,
        faviconPrefix,
        themeColor,
        webManifestFileName,
        safariIconFileName,
        fontFileName,
        outputCssFileName,
        baseUrl,
        tagGroups,
    } = props as BaseProps;

    return (
        <html lang="en">
            <HeadMeta
                firstName={firstName}
                lastName={lastName}
                gitRevision={gitRevision}
                msTileColor={msTileColor}
                faviconPrefix={faviconPrefix}
                themeColor={themeColor}
                webManifestFileName={webManifestFileName}
                safariIconFileName={safariIconFileName}
                fontFileName={fontFileName}
                outputCssFileName={outputCssFileName}
                baseUrl={baseUrl}
            />

            <body>
                <Header firstName={firstName} lastName={lastName} links={links} />

                <About firstName={firstName} />

                <TagCloud firstName={firstName} tagGroups={tagGroups} />

                <Footer
                    firstName={firstName}
                    lastName={lastName}
                    gitRevision={gitRevision}
                    githubLink={githubLink}
                />
            </body>
        </html>
    );
}

export default Base;
