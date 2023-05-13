const activityContainer = document.querySelector('#activity')

fetch(window.location)
  .then(async response => {
    const bearer = response.headers.get('x-mercure-token')
    const topic  = response.headers.get('x-mercure-topic')
    const hubUrl = response.headers.get('Link')
        .match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1]

    const hub = new URL(hubUrl, window.origin);

    hub.searchParams.append('topic', topic)

    const options = !bearer
      ? {}
      : {
          headers: {
              'Authorization': bearer,
          }
        }

    const es = new EventSourcePolyfill(hub, options)

    es.onmessage = event => {
      const data = JSON.parse(event.data)

      const item = document.createElement('div')

      item.setAttribute('class', 'alert alert-primary')
      item.setAttribute('role', 'alert')

      item.innerHTML = data.message

      activityContainer.append(item)
    }
  })
