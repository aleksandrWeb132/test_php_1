function searchPosts(url, body) {
    request(url, 'POST', body)
        .then(data => {
            if(data.code === 1) {
                createRow(data.body);
            }
        })
        .catch(error => {
            console.log(error);
        });
}

function getPosts(url) {
    request(url, 'GET')
        .then(data => {
            if(data.code === 1) {
                createRow(data.body);
            }
        })
        .catch(error => {
            console.log(error);
        });
}

function createRow(posts) {
    const tbody = document.getElementById('table-body');

    tbody.innerHTML = '';

    posts.forEach((post) => {
        const row = document.createElement('tr');
        row.innerHTML = `<td>${post.ID}</td><td>${post.USER_ID}</td><td>${post.TITLE}</td><td>${post.BODY}</td>`;

        tbody.appendChild(row);
    })
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