const alertContainer = document.querySelector('#alert-container')
const template = document.querySelector('#dinosaur-item-template')
const dinosaurList = document.querySelector('#dinosaur-list')

fetch(window.location)
  .then(async response => {
      const topic = response.headers.get('x-mercure-topic')
      const hubUrl = response.headers.get('Link').match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1]

      const hub = new URL(hubUrl);

      hub.searchParams.append('topic', topic)

      const es = new EventSource(hub)

      es.onmessage = e => {
        const dinosaur = JSON.parse(e.data)

        const clone = template.content.cloneNode(true)
        const dinosaurTemplateNameContainer = clone.querySelector('#dinosaur-item-template-name')
        const dinosaurTemplateLinkContainer = clone.querySelector('#dinosaur-item-template-link')

        dinosaurTemplateNameContainer.innerHTML = dinosaur.name
        dinosaurTemplateLinkContainer.href = dinosaur.link

        dinosaurList.append(clone)

        alertContainer.innerHTML =`<div class='alert alert-success'>Welcome to ${dinosaur.name}!</div>`

        window.setTimeout(() => {
          const alert = document.querySelector('.alert')
          alert.parentNode.removeChild(alert)
        }, 5000);
      }
  })
