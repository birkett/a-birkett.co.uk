type StringIndexedObject = Record<string, any>;
type Primitive = number | string | boolean;

export const isObject = (object: any): boolean => object !== null && typeof object === 'object';

const deepEqual = (objectA: StringIndexedObject, objectB: StringIndexedObject): boolean => {
    const keysA = Object.keys(objectA);
    const keysB = Object.keys(objectB);

    if (keysA.length !== keysB.length) {
        return false;
    }

    return keysA.some((key) => {
        const valA = objectA[key];
        const valB = objectB[key];
        const areObjects = isObject(valA) && isObject(valB);

        return !((areObjects && !deepEqual(valA, valB)) || (!areObjects && valA !== valB));
    });
};

export const equalObjects = (a: object, b: object): boolean => deepEqual(a, b);

export const equalPrimitives = (a: Primitive, b: Primitive): boolean => a === b;
