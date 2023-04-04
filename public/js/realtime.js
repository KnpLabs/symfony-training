const alertContainer = document.querySelector('#alert-container')
const template = document.querySelector('#dinosaur-item-template')
const dinosaurList = document.querySelector('#dinosaur-list')

const url = new URL("http://localhost:81/.well-known/mercure")
url.searchParams.append('topic', 'http://dinosaur-app/dinosaurs/create')

const eventSource = new EventSource(url)

eventSource.onmessage = e => {
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
