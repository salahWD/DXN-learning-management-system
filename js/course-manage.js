const itemsType = document.querySelectorAll(".item-type");
const sendBtn   = document.getElementById("sendBtn");

itemsType.forEach(itemType => {
  itemType.addEventListener("click", () => {
    itemsType.forEach(item => {
      item.classList.remove("border-primary");
    });
    sendBtn.setAttribute("href", "http://localhost/dxnln/ar/" + itemType.getAttribute("data-page"));
    itemType.classList.add("border-primary");
  });
  sendBtn.setAttribute("href", "http://localhost/dxnln/ar/lecture-add");
});