var xhr = function(verb, path, payload, onsuccess, onerror) {
    var request = new XMLHttpRequest();

    request.onload = function() {
        if (request.status === 200) {
            onsuccess(request.responseText);
        } else {
            onerror(request.responseText, request.status);
        }
    }

    request.open(verb, path);

    if (payload) {
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        payload = urlencode_map(payload);
    } else {
        payload = null;
    }

    request.send(payload);
}

function urlencode_map(map) {
    var encoded = '';
    for (var [key, value] of map) {
        if (encoded.length > 0) encoded += '&';

        encoded += encodeURI(key + '=' + value);
    }
    return encoded;
}

