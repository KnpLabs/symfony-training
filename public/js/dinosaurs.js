const alertContainer = document.querySelector('#alert-container')
const template = document.querySelector('#dinosaur-item-template')
const dinosaurList = document.querySelector('#dinosaur-list')

const displayToast = (message) => {
  alertContainer.innerHTML = `<div class='alert alert-success'>${message}</div>`
  window.setTimeout(() => {
    const alert = document.querySelector('.alert')
    alert.parentNode.removeChild(alert)
  }, 5000)
}

const createDinosaur = (name, link) => {
  const clone = template.content.cloneNode(true)
  const dinosaurTemplateNameContainer = clone.querySelector('#dinosaur-item-template-name')
  const dinosaurTemplateLinkContainer = clone.querySelector('#dinosaur-item-template-link')

  dinosaurTemplateNameContainer.innerHTML = name
  dinosaurTemplateLinkContainer.href = link

  dinosaurList.append(clone)

  displayToast(`Welcome to ${name}!`)
}

const removeDinosaur = (id) => {
  const item = document.querySelector(`a[data-id="${id}"]`)
  item.remove()

  displayToast(`A dinosaur has been removed !`)
}

const editDinosaur = (data) => {
  const item = document.querySelector(`a[data-id="${data.id}"]`)
  const name = item.querySelector('div')
  name.innerHTML = data.name
}

fetch(window.location)
  .then(async response => {
    const topic = response.headers.get('x-mercure-topic')
    const hubUrl = response.headers.get('Link').match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1]

    const hub = new URL(hubUrl);

    hub.searchParams.append('topic', topic)

    const es = new EventSource(hub)

    es.onmessage = e => {
      const message = JSON.parse(e.data)

      switch (message.type) {
        case 'create':
          createDinosaur(message.name, message.link)
          break
        case 'remove':
          removeDinosaur(message.id)
          break
        case 'edit':
          editDinosaur(message.data)
          break
      }
    }
  })
