type FunctionalComponent = (props: Partial<Props>) => JSX.Element;
type TsxElement = string | FunctionalComponent;

export interface Props {
    [key: string]: string | [] | object | ComponentStyles;
}

interface PropertyRewrites {
    [key: string]: string;
}

const propertyRewrites: PropertyRewrites = {
    httpEquiv: 'http-equiv',
    className: 'class',
    backgroundColor: 'background-color',
};

interface VoidElements {
    [key: string]: string;
}

const voidElements: VoidElements = {
    meta: 'meta',
    link: 'link',
    br: 'br',
};

interface ComponentStyles {
    [key: string]: string;
}

const parseStyledComponent = (styles: ComponentStyles): string => {
    let styleString = '';

    Object.keys(styles).forEach((styleKey) => {
        styleString += `${propertyRewrites[styleKey] || styleKey}:${styles[styleKey]};`;
    });

    return styleString;
};

const parseNode = (element: string, properties: Partial<Props>, children: string[]) => {
    let elementString = `<${element}`;

    Object.keys(properties).forEach((property) => {
        if (property === 'style') {
            elementString += ` style="${parseStyledComponent(
                properties[property] as ComponentStyles,
            )}"`;

            return;
        }

        elementString += ` ${propertyRewrites[property] || property}="${properties[property]}" `;
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

export default tsxParser;
