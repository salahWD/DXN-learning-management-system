$(document).ready(function(){

  const answersForm   = document.getElementById("answersForm");
  const checkBtn      = $("#send");
  let   questions     = document.querySelectorAll(".question-show");
  let   result        = document.getElementById("result");
  let   resultAlert   = document.getElementById("result-alert");
  let   resultStatus  = document.getElementById("result-status");
  let   resultText    = document.getElementById("result-text");
  let   resItemContain   = document.getElementById("result-itemsContaioner");
  let   resultItems   = document.getElementById("result-items");

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

      $.ajax({
        method: "POST",
        url: "http://localhost/dxnln/ar/exam-proces",
        data: postData,
        success: function (data, status, xhr) {
          
          if (status == "status" || xhr.status == 200) {
            
            data = JSON.parse(data);
            
            function QuestionElement(id, answers, mark) {
              let element = document.createElement("li");
              element.classList.add("list-grou-item");
              element.id = `mark_${id}`;

              answers.forEach(answer => {
                let ansr = document.createElement("div");
                ansr.innerHTML = answer.id;
                if (answer.is_right == 2) {
                  ansr.classList.add("bg-success");
                }else {
                  ansr.classList.add("bg-danger");
                }
                element.appendChild(ansr);
              });

              let grade = document.createElement("span");
              grade.classList.add("grade");
              grade.innerHTML = mark;
              element.appendChild(grade);

              return element;
            }

            result.classList.remove("d-none");

            console.log(data);
            
            if (data.exam_full_mark >= data.min_mark) {
              resultAlert.classList.add("alert-success");
              resItemContain.classList.add("border-success");
              resultStatus.innerHTML = "Successes";
            }else {
              resultAlert.classList.add("alert-danger");
              resItemContain.classList.add("border-danger");
              resultStatus.innerHTML = "Fail";
            }

            data.questions_mark.forEach(question => {
              let questionEl = QuestionElement(...question);
              resultItems.appendChild(questionEl);
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