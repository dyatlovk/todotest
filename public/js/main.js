(function() {
  if (!document.getElementById('notify')) return;

  var notify = document.getElementById('notify');
  var close = notify.getElementsByClassName('notify-close')[0];
  close.addEventListener('click', onCloseClick)

  function onCloseClick() {
    hide()
  }

  setTimeout(function() {
    hide()
  }, 4000);

  function hide() {
    notify.style.display = 'none';
  }
})()
