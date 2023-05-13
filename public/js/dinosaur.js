const alertContainer = document.querySelector('#alert-container')

fetch(window.location)
  .then(async response => {
    const topic = response.headers.get('x-mercure-topic')
    const hubUrl = response.headers.get('Link').match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1]

    const hub = new URL(hubUrl);

    hub.searchParams.append('topic', topic)

    const es = new EventSource(hub)

    es.onmessage = e => {
       const item = document.createElement('div')

      item.setAttribute('class', 'alert alert-danger')
      item.setAttribute('role', 'alert')

      item.innerHTML = 'Dinosaur has changed !'

      alertContainer.innerHTML = ''
      alertContainer.append(item)
    }
  })
