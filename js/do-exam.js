if (document.getElementById("exam")) {
  const answersForm     = document.getElementById("answersForm");
  let   questions       = document.querySelectorAll(".question-show");
  
  answersForm.addEventListener("submit", function (e) {
  
    questions.forEach( inp => {
      if (inp.querySelectorAll("input:checked").length == 0) {
        inp.classList.add("border-danger", "border", "rounded");
        inp.querySelector(`.question-text`).classList.add("text-danger");
      }else {
        inp.classList.remove("border-danger");
        inp.querySelector(`.question-text`).classList.remove("text-danger");
      }
    });
  
    if ($(`.question-show.border-danger`).length > 0) {
      e.preventDefault();
      window.scroll({
        top: document.querySelector(`.question-show.border-danger`).offsetTop - 40,
        left: 100,
        behavior: 'smooth'
      });
  
    }
    
  });
}