import { PromiseRejectFn, PromiseResolveFn } from './PromiseRejectResolve';

export type BuildTask = (resolve: PromiseResolveFn, reject: PromiseRejectFn) => void;

export type BuildJob = Record<string, BuildTask[]>;
