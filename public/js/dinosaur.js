const alertContainer = document.querySelector('#alert-container')
const template = document.querySelector('#dinosaur-item-template')
const dinosaurList = document.querySelector('#dinosaur-list')
const dinosaurSection = document.querySelector('#dinosaur-section')
const dinosaurId = dinosaurSection.dataset.id

fetch(`/api/dinosaurs/${dinosaurId}`)
  .then(async response => {
    // Extract the hub URL from the Link header
    const hubUrl = response.headers.get('Link').match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1]

    const hub = new URL(hubUrl, window.origin);
    const body = await response.json()

    console.log(body)
    hub.searchParams.append('topic', body.topic)

    // Subscribe to updates
    const eventSource = new EventSource(hub);
    eventSource.onmessage = event => window.location.reload()
  });
