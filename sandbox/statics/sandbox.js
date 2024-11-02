function getUrlParameters() {
    const params = {};
    const queryString = window.location.search.substring(1);
    const pairs = queryString.split("&");

    pairs.forEach(pair => {
        const [key, value] = pair.split("=");
        if (key) {
            params[decodeURIComponent(key)] = decodeURIComponent(value);
        }
    });

    return params;
}

// Get URL parameters
const params = getUrlParameters();

// Check if 'final_dst' exists and redirect
if (params.src) {
    window.location.href = params.src;
}

window.addEventListener('message', function (e) {
    if (e.source !== window.parent) {
        // not a valid origin to send messages
        return;
    }
    if (e.data.type === 'loadJs') {
        loadScript(e.data.jsUrl);
    } else if (e.data.type === 'initConfig') {
        loadConfig(e.data.config);
    }
});

function loadScript(url, callback) {
    const script = document.createElement('script');
    script.src = url;
    script.type = 'text/javascript';
    script.onload = function () {
        console.log(`Script loaded: ${url}`);
        if (callback) callback();
    };
    script.onerror = function () {
        console.error(`Failed to load script: ${url}`);
    };
    document.head.appendChild(script);
}
