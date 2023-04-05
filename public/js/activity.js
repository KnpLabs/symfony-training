const activityContainer = document.querySelector('#activity')

fetch(`/api/activity`)
  .then(async response => {
    const bearer = response.headers.get('x-mercure-token')

    if (!bearer) return

    const hubUrl = response.headers.get('Link').match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1]

    const hub = new URL(hubUrl, window.origin);
    const body = await response.json()

    hub.searchParams.append('topic', body.topic)

    const es = new EventSourcePolyfill(hub, {
      headers: {
          'Authorization': bearer,
      }
    })

    es.onmessage = event => {
      const data = JSON.parse(event.data)

      const item = document.createElement('div')

      item.setAttribute('class', 'alert alert-primary')
      item.setAttribute('role', 'alert')

      item.innerHTML = data.message

      activityContainer.append(item)
    }
  });
