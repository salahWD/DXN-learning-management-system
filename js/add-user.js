// Toggle Student form and Teacher form
function togleForm(type) {
  if (type) {
    document.querySelectorAll(`.input-container.student`).forEach(function (inp) {
      let input = inp.querySelector(`input`);
      inp.style.display = "none";
      input.name = "";
    });
    document.querySelectorAll(`.input-container.teacher`).forEach(function (inp) {
      let input = inp.querySelector(`input`);
      inp.style.display = "flex";
      input.name = input.getAttribute("data-name");
    });
  }else {
    document.querySelectorAll(`.input-container.teacher`).forEach(function (inp) {
      let input = inp.querySelector(`input`);
      inp.style.display = "none";
      input.name = "";
    });
    document.querySelectorAll(`.input-container.student`).forEach(function (inp) {
      let input = inp.querySelector(`input`);
      inp.style.display = "flex";
      input.name = input.getAttribute("data-name");
    });
  }
}

let teacher = document.getElementById("teacher");
let student = document.getElementById("student");

if (teacher) {
  teacher.addEventListener("click", function () {
    togleForm(true);
  });
}

if (student) {
  student.addEventListener("click", function() {
    togleForm(false);
  });
  togleForm(false);
}