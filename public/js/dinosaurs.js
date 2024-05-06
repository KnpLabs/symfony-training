const alertContainer = document.querySelector('#alert-container')
const template = document.querySelector('#dinosaur-item-template')
const dinosaurList = document.querySelector('#dinosaurs-list')

const hub = new URL('http://localhost:81/.well-known/mercure')
hub.searchParams.append('topic', 'http://localhost/dinosaurs')

const es = new EventSource(hub);

const displayToast = (message) => {
    alertContainer.innerHTML = `<div class='alert alert-success'>${message}</div>`

    window.setTimeout(() => {
        const alert = document.querySelector('.alert')
        alert.parentNode.removeChild(alert)
    }, 5000)
}

const addDinosaur = (id, name, link, message) => {
    const clone = template.content.cloneNode(true)
    const dinosaurTemplateNameContainer = clone.querySelector('.dinosaur-name')
    const dinosaurTemplateLinkContainer = clone.querySelector('.dinosaur-link')

    dinosaurTemplateNameContainer.innerHTML = name
    dinosaurTemplateLinkContainer.href = link
    dinosaurTemplateLinkContainer['data-id'] = id

    dinosaurList.append(clone)

    displayToast(message)
}

const updateDinosaur = (id, name, message) => {
    const dinosaur = document.querySelector(`[data-id='${id}']`)

    if(dinosaur) {
        dinosaur.querySelector('.dinosaur-name').innerHTML = name

        displayToast(message)
    }
}

const removeDinosaur = (id, message) => {
    const dinosaur = document.querySelector(`[data-id='${id}']`)

    if(dinosaur) {
        dinosaur.parentNode.removeChild(dinosaur)

        displayToast(message)
    }
}

es.addEventListener('created', e => {
    const message = JSON.parse(e.data)

    addDinosaur(
        message.id,
        message.name,
        message.link,
        message.message
    )
})

es.addEventListener('updated', e => {
    const message = JSON.parse(e.data)

    updateDinosaur(
        message.id,
        message.name,
        message.message
    )
})

es.addEventListener('deleted', e => {
    const message = JSON.parse(e.data)

    removeDinosaur(
        message.id,
        message.message
    )
})
