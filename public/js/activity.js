const activityContainer = document.querySelector('#activity-container')


const dicoverMercureHub = async () => fetch(window.location)
    .then(response => {
        const hubUrl = response
            .headers
            .get('Link')
            .match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1];

        return {
            url: new URL(hubUrl),
            token: response.headers.get('X-Mercure-JWT'),
        }
    }
)

const addLogItem = (message) => {
    const item = document.createElement('li')

    item.setAttribute('class', 'alert alert-primary')
    item.setAttribute('role', 'alert')

    item.innerHTML = message

    activityContainer.append(item)
}

document.addEventListener('DOMContentLoaded', async () => {
    const { url, token } = await dicoverMercureHub()

    url.searchParams.append('topic', 'http://localhost/activity')
    url.searchParams.append('topic', 'http://localhost/dinosaurs')

    const options = token ? { headers: { Authorization: `Bearer ${token}` }, withCredentials: true } : {}

    const es = new EventSourcePolyfill(url, options)

    es.addEventListener('login', e => {
        const message = JSON.parse(e.data)

        addLogItem(message.message)
    })

    es.addEventListener('logout', e => {
        const message = JSON.parse(e.data)

        addLogItem(message.message)
    })

    es.addEventListener('created', e => {
        const message = JSON.parse(e.data)

        addLogItem(message.message)
    })

    es.addEventListener('updated', e => {
        const message = JSON.parse(e.data)

        addLogItem(message.message)
    })

    es.addEventListener('deleted', e => {
        const message = JSON.parse(e.data)

        addLogItem(message.message)
    })
});
