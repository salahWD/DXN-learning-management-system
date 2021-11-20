$(document).ready(function(){

  const answersForm   = document.getElementById("answersForm");
  const checkBtn      = $("#send");
  let   questions       = document.querySelectorAll(".question-show");
  checkBtn.click(function () {

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
      window.scroll({
        top: $(`.question-show.border-danger`)[0].affsetTop - 40,
        left: 100,
        behavior: 'smooth'
      });
    }else {

      let postData = {
        exam_id: answersForm.dataset.value,
        questions: {},
      };

      questions.forEach(question => {
        let answerElement = question.querySelectorAll('input:checked');
        let answers = [];

        answerElement.forEach(element => {
          answers.push(element.value);
        });

        postData.questions[`${question.dataset.value}`] = answers;
        
      });

      console.log(JSON.stringify(postData));

      $.ajax({
        method: "POST",
        url: "http://localhost/dxnln/ar/exam-proces",
        data: postData,
        success: function (data, status, xhr) {
          if (status == "status" || xhr.status == 200) {
            data = JSON.parse(data);
            console.log(data[0]);
            data[1].forEach(el => {
              console.log(el[0]);
              console.log(`===== >${el[1]}`);
            });
          }else {
            console.error("ajax request is no success");
          }
        },
        error: function (data) {
          console.error(data);
        }
      });
      
    }
  });
});