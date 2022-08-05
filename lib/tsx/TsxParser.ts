type FunctionalComponent = (props: Partial<Props>) => JSX.Element;
type TsxElement = string | FunctionalComponent;

export interface Props {
    [key: string]: string | [];
}

interface PropertRewrites {
    [key: string]: string;
}

const propertyRewrites: PropertRewrites = {
    httpEquiv: 'http-equiv',
    className: 'class',
};

interface VoidElements {
    [key: string]: string;
}

const voidElements: VoidElements = {
    meta: 'meta',
    link: 'link',
    br: 'br',
};

const parseNode = (element: string, properties: Partial<Props>, children: string[]) => {
    let elementString = `<${element} `;

    Object.keys(properties).forEach((property) => {
        elementString += `${propertyRewrites[property] || property}="${properties[property]}" `;
    });

    elementString += voidElements[element] ? '/>' : '>';

    children.forEach((child) => {
        elementString += child;
    });

    if (!voidElements[element]) {
        elementString += `</${element}>`;
    }

    return elementString;
};

const tsxParser = (element: TsxElement, properties: Partial<Props> = {}, ...children: string[]) => {
    if (typeof element === 'function') {
        return element(properties);
    }

    return parseNode(element, properties || {}, children);
};

export const textAddSpaces = (text?: string): string => `&nbsp${text}&nbsp`;

export default tsxParser;
