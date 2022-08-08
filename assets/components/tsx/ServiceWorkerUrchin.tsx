import h, { FunctionComponent } from '../../../lib/tsx/TsxParser';

interface UrchinProps {
    gitRevision: string;
    serviceWorkerUrchinFileName: string;
}

export const ServiceWorkerUrchin: FunctionComponent<UrchinProps> = (props: UrchinProps) => {
    const { gitRevision, serviceWorkerUrchinFileName } = props;

    return <script defer src={`${serviceWorkerUrchinFileName}?v=${gitRevision}`} />;
};
