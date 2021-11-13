const checkBtn  = document.getElementById(`send`);
let   answers   = document.querySelectorAll(`.question-show`);

function reqListener () {
  console.log(this.responseText);
}

checkBtn.addEventListener("click", function () {
  answers.forEach(inp => {
    if (inp.querySelectorAll(`input:checked`).length == 0) {
      inp.classList.add("border-danger", "border", "rounded");
      inp.querySelector(`.question-text`).classList.add("text-danger");
    }else {
      inp.classList.remove("border-danger");
      inp.querySelector(`.question-text`).classList.remove("text-danger");
    }
  });

  if (document.querySelectorAll(`.question-show.border-danger`).length > 0) {
    window.scroll({
      top: document.querySelectorAll(`.question-show.border-danger`)[0].offsetTop - 30,
      left: 100,
      behavior: 'smooth'
    });
  }else {
    document.forms[0].submit();
  }

});