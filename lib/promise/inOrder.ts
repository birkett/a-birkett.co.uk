const promiseInOrder = async (tasks: any[], promiseFunction: (arg0: any, arg1: any) => any) => {
    tasks.reduce(async (previous, next) => {
        await previous;

        return promiseFunction(previous, next);
    }, Promise.resolve());
};

export default promiseInOrder;
