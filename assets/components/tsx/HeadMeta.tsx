import h from '../../../lib/tsx/TsxParser';

interface HeadMetaProps {
    firstName: string;
    lastName: string;
    gitRevision: string;
    msTileColor: string;
    faviconPrefix: string;
    themeColor: string;
    webManifestFileName: string;
    safariIconFileName: string;
    fontFileName: string;
    outputCssFileName: string;
    baseUrl: string;
}

function HeadMeta(props: Partial<HeadMetaProps>): JSX.Element {
    const {
        firstName,
        lastName,
        gitRevision,
        msTileColor,
        faviconPrefix,
        themeColor,
        webManifestFileName,
        safariIconFileName,
        fontFileName,
        outputCssFileName,
        baseUrl,
    } = props as HeadMetaProps;

    const description = `Personal website of ${firstName} ${lastName}, IT guy and Engineer.`;

    return (
        <head>
            <title>
                {firstName} {lastName}
            </title>

            <meta httpEquiv="Content-Type" content="text/html; charset=UTF-8" />

            <meta name="description" content={description} />

            <meta name="viewport" content="width=device-width, initial-scale=1" />

            <meta name="msapplication-TileColor" content={msTileColor} />

            <meta
                name="msapplication-TileImage"
                content={`${faviconPrefix}-144x144.png?v=${gitRevision}`}
            />

            <meta name="theme-color" content={themeColor} />

            <meta name="msapplication-config" content={`browserconfig.xml?v=${gitRevision}`} />

            <link
                rel="icon"
                type="image/png"
                sizes="16x16"
                href={`${faviconPrefix}-16.png?v=${gitRevision}`}
            />

            <link
                rel="icon"
                type="image/png"
                sizes="24x24"
                href={`${faviconPrefix}-24.png?v=${gitRevision}`}
            />

            <link
                rel="icon"
                type="image/png"
                sizes="32x32"
                href={`${faviconPrefix}-32.png?v=${gitRevision}`}
            />

            <link
                rel="icon"
                type="image/png"
                sizes="48x48"
                href={`${faviconPrefix}-48.png?v=${gitRevision}`}
            />

            <link
                rel="icon"
                type="image/png"
                sizes="57x57"
                href={`{${faviconPrefix}-57.png?v=${gitRevision}`}
            />

            <link
                rel="icon"
                type="image/png"
                sizes="64x64"
                href={`${faviconPrefix}-64.png?v=${gitRevision}`}
            />

            <link
                rel="icon"
                type="image/png"
                sizes="72x72"
                href={`${faviconPrefix}-72.png?v=${gitRevision}`}
            />

            <link
                rel="icon"
                type="image/png"
                sizes="96x96"
                href={`${faviconPrefix}-96.png?v=${gitRevision}`}
            />

            <link
                rel="icon"
                type="image/png"
                sizes="128x128"
                href={`${faviconPrefix}-128.png?v=${gitRevision}`}
            />

            <link
                rel="icon"
                type="image/png"
                sizes="192x192"
                href={`${faviconPrefix}-192.png?v=${gitRevision}`}
            />

            <link
                rel="icon"
                type="image/png"
                sizes="228x228"
                href={`${faviconPrefix}-228.png?v=${gitRevision}`}
            />

            <link
                rel="shortcut icon"
                type="image/png"
                sizes="196x196"
                href={`${faviconPrefix}-196.png?v=${gitRevision}`}
            />

            <link
                rel="apple-touch-icon"
                sizes="120x120"
                href={`${faviconPrefix}-120.png?v=${gitRevision}`}
            />

            <link
                rel="apple-touch-icon"
                sizes="152x152"
                href={`${faviconPrefix}-152.png?v=${gitRevision}`}
            />

            <link
                rel="apple-touch-icon"
                sizes="180x180"
                href={`${faviconPrefix}-180.png?v=${gitRevision}`}
            />

            <link rel="manifest" href={`${webManifestFileName}?v=${gitRevision}`} />

            <link
                rel="mask-icon"
                href={`${safariIconFileName}?v=${gitRevision}`}
                color={themeColor}
            />

            <link rel="shortcut icon" href={`${faviconPrefix}.ico?v=${gitRevision}`} />

            <link
                rel="preload"
                as="font"
                type="font/woff2"
                href={`fonts/${fontFileName}?v=${gitRevision}`}
                crossOrigin=""
            />

            <link rel="stylesheet" href={`css/${outputCssFileName}}?v=${gitRevision}`} />

            <link rel="canonical" href={baseUrl} />
        </head>
    );
}

export default HeadMeta;
