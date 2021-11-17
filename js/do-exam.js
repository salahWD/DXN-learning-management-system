$(document).ready(function(){

  const answersForm   = document.getElementById("answersForm");
  const checkBtn      = $("#send");
  let   answers       = document.querySelectorAll(".question-show");
  checkBtn.click(function () {

    answers.forEach( inp => {
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
        question_count: answers.length,
        questions: [],
      };

      answers.forEach(question => {
        let answerElement = question.querySelectorAll('input:checked');
        let answers = [];

        answerElement.forEach(element => {
          answers.push({id: element.value});
        });

        postData.questions.push({id: question.dataset.value, answers: answers});
        
      });

      console.log(JSON.stringify(postData));

      $.ajax({
        method: "POST",
        url: "http://localhost/dxnln/ar/exam-proces",
        data: postData,
        success: function (data, status, xhr) {
          if (status == "status" || xhr.status == 200) {
            console.log(data);
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