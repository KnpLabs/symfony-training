document.addEventListener('DOMContentLoaded', () => {
  const dinoImg = document.querySelector('.dino-image');
  if (dinoImg === null) {
    return;
  }

  dinoImg.addEventListener('click', e => {
    const r = Math.floor((Math.random() * 256));
    const g = Math.floor((Math.random() * 256));
    const b = Math.floor((Math.random() * 256));
    const name = document.getElementById('dino-name');

    if (null !== name) {
      name.style.color = `rgb(${r},${g},${b})`;
    }
  });
});
