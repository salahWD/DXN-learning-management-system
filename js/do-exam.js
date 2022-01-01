$(document).ready(function(){

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

<<<<<<< HEAD
=======
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
            // console.log(data);
            function QuestionElement(id, answers, mark) {
              let element = document.createElement("li");
              element.classList.add("list-grou-item");
              element.style.gridTemplateColumns = `repeat(${answers.length}, 1fr) 50px`;
              element.id = `mark_${id}`;

              answers.forEach(answer => {
                let ansr = document.createElement("div");
                let answerText = document.querySelector(`.fw-normal[for="${document.querySelector(`.form-check input[value="${answer.id}"]`).id}"]`).textContent;
                ansr.innerHTML = answerText;
                ansr.classList.add("alert", "m-0", "p-1");
                if (answer.is_right == 2) {
                  ansr.classList.add("alert-success");
                }else {
                  ansr.classList.add("alert-danger");
                }
                element.appendChild(ansr);
              });

              let grade = document.createElement("span");
              grade.classList.add("grade");
              grade.innerHTML = Math.floor(mark);
              element.appendChild(grade);

              return element;
            }

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
              let questionEl = QuestionElement(question[0]/* Q_id */, question[1]/* answers */, question[2]/* mark */);
              resultItems.appendChild(questionEl);
            });
            
            result.classList.remove("d-none");
            examElement.remove();

          }else {
            console.error("ajax request is no success");
          }
        },
        error: function (data) {
          console.error(data);
        }
      });
      
>>>>>>> 3efd29c6b1f3ba1d73f82e9b41bb5ab8b8bcdafa
    }
    
  });
});