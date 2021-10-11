const memoize = (func: () => any): any => {
    const memoized: any = () => {
        if (memoized.cache) {
            return memoized.cache;
        }

        memoized.cache = func();

        return memoized.cache;
    };

    return memoized;
};

export default memoize;
