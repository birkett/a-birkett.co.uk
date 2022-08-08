import h, { FunctionComponent } from '@tsx/TsxParser';
import { Footer } from '@components/Footer';
import { Header } from '@components/Header';
import { About } from '@components/About';
import { TagCloud, TagGroups } from '@components/TagCloud';
import { HeadMeta } from '@components/HeadMeta';
import { ServiceWorkerUrchin } from '@components/ServiceWorkerUrchin';
import { LinkProps } from '@components/Link';

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
    serviceWorkerUrchinFileName: string;
}

export const Base: FunctionComponent<BaseProps> = (props: BaseProps) => {
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
        serviceWorkerUrchinFileName,
    } = props;

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

                <ServiceWorkerUrchin
                    serviceWorkerUrchinFileName={serviceWorkerUrchinFileName}
                    gitRevision={gitRevision}
                />
            </body>
        </html>
    );
};
