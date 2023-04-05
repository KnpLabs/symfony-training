const alertContainer = document.querySelector('#alert-container')
const template = document.querySelector('#dinosaur-item-template')
const dinosaurList = document.querySelector('#dinosaur-list')
const dinosaurSection = document.querySelector('#dinosaur-section')
const dinosaurId = dinosaurSection.dataset.id

fetch(`/api/dinosaurs/${dinosaurId}`)
  .then(async response => {
    const bearer = response.headers.get('x-mercure-token')

    /*
     * If no JWT is provided, it means that the user won't
     * be able to subscribe to the updates.
     */
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

    es.onmessage = event => console.log(event)
  });
