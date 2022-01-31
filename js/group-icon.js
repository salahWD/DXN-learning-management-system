if (document.querySelector(".icon")) {
  let icons = document.querySelectorAll(".icon");
  let input = document.getElementById("icon-id-input");
  icons.forEach(icon => {
    icon.addEventListener("click", () => {
      input.value = icon.dataset.id;
    });
  });
}