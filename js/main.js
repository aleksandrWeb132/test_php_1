function searchPosts(url, body) {
    request(url, 'POST', body)
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.log(error);
        });
}

function getPosts(url) {
    request(url, 'GET')
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.log(error);
        });
}

async function request(url, method, body = undefined) {
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        }
    };

    if(body !== undefined) {
        options.body = JSON.stringify(body);
    }

    try {
        const response = await fetch(url, options);

        return response.status !== 204 ? await response.json() : null;
    }
    catch(error) {
        throw error;
    }
}