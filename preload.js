function showToast(message, type) {
  let backgroundColor;
  if (type === 'success') {
    backgroundColor = "linear-gradient(to right, #00b09b, #96c93d)";
  } else if (type === 'error') {
    backgroundColor = "linear-gradient(to right, #ff5f6d, #ffc371)";
  } else {
    backgroundColor = "linear-gradient(to right, #00b09b, #96c93d)";
  }

  Toastify({
    text: message,
    duration: 3000,
    style: {
      backgroundColor: backgroundColor,
    },
    close: true,
    gravity: "top",
    position: "right",
    stopOnFocus: true,
    newWindow: true,
    className: "toastify",
  }).showToast();
}

