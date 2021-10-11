# Personal website of Anthony Birkett

Simple personal website.

## Building

```shell script
npm install
npm run build
```

## Deploying

After building, the entire `/dist` directory can be copied to a simple web server.
No server side dependencies needed.

## Automated deployment

A simple deployment script and nginx config is included to automate deployment.

For this to run:

-   SSH must be pre-configured on both the local and remote machine
-   Permissions need to be set on the site root directory
-   Permissions need to be set on the nginx config
-   The user you use on the remote machine should be able to restart nginx

```shell script
npm run deploy <hostname>
```

## Browser Support

Makes extensive use of SVGs, CSS animations, filters and em units.

-   Should work on anything this decade (Chrome, Firefox, Edge, Safari, iOS, Android).
-   IE, not even attempting to support.
