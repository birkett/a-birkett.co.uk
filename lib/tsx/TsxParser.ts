type FunctionalComponent = (props: Props) => JSX.Element;
type TsxElement = string | FunctionalComponent;

export interface Props {
    [key: string]: string;
}

const parseNode = (element: string, children: string[]) => {
    let elementString = `<${element}>`;

    children.forEach((child) => {
        elementString += child;
    });

    elementString += `</${element}>`;

    return elementString;
};

const tsxParser = (element: TsxElement, properties: Props = {}, ...children: string[]) => {
    if (typeof element === 'function') {
        return element(properties);
    }

    return parseNode(element, children);
};

export const textAddSpaces = (text?: string): string => `&nbsp${text}&nbsp`;

export default tsxParser;
