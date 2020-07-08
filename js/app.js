function sort(el) {
    let url = location.href.substring(0, location.href.indexOf('?'));
    url += '?';
    let params = getParams();
    params['sort'] = el.value;

    for (let key of Object.keys(params)) {
        url += key + '=' + params[key] + '&';
    }

    url = url.replace(/&$/, '');

    location.href = url;
}

function getParams() {
    let vars = {};
    let parts = location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
