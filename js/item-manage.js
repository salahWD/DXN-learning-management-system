if (document.getElementById("thumbnail-input")) {
  const imageInput    = document.getElementById("thumbnail-input");
  const imageEditBtn  = document.getElementById("thumbnail-btn");

  imageEditBtn.addEventListener("click", function () {
    imageInput.click();
  });
}