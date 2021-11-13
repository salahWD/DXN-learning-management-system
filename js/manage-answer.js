const answerContainer = document.getElementById(`answer-container`);

if (answerContainer) {
  const quesText  = document.getElementById(`question-content`);
  const quesInput = document.getElementById(`question-input`);
  const addAns    = document.getElementById(`add-answer`);
  
  //    add answer Button
  addAns.addEventListener("click", (e) => {
    e.preventDefault();
    addAnswer();
  });

  //    add answer
  function addAnswer() {
    let id = document.querySelectorAll(`#answer-container .answer[data-status="add"]`).length + 1;
    
    let answerBody = document.createElement("div");
    answerBody.classList.add("input-group", "answer", "mb-3");
    answerBody.setAttribute("data-status", "add");
    
    let right = document.createElement("input");
    right.type = `hidden`;
    right.name = `answer[${id}][is_right]`;
    right.value = 1;
    answerBody.appendChild(right);
    
    let question_id;
    if (question_id = document.querySelector(`.card .card-header input[name="quest_id"]`)) {
      let quest_id = document.createElement("input");
      quest_id.type = `hidden`;
      quest_id.name = `answer[${id}][quest_id]`;
      quest_id.value = question_id.value;
      answerBody.appendChild(quest_id);
    }
    
    let input = document.createElement("input");
    input.classList.add("form-control");
    input.name = `answer[${id}][answer]`;
    input.placeholder = `Answer ${id}`;
    answerBody.appendChild(input);
    
    let check = document.createElement("button");
    check.classList.add("btn", "btn-outline-success");
    check.type = `button`;
    check.innerHTML = `<i class="fa fa-lg fa-check"></i>`;
    answerBody.appendChild(check);
    check.addEventListener("click" , () => {
      check.classList.toggle("active");
      if (check.classList.contains("active")) {
        check.parentElement.querySelector(`input[type="hidden"]`).value = 2;
      }else {
        check.parentElement.querySelector(`input[type="hidden"]`).value = 1;
      }
    });
    
    let remove = document.createElement("button");
    remove.classList.add("btn", "btn-outline-danger");
    remove.type = `button`;
    remove.innerHTML = `<i class="fa fa-lg fa-trash"></i>`;
    answerBody.appendChild(remove);
    remove.addEventListener("click", () => {deleteAnswer(remove)});
    
    answerContainer.appendChild(answerBody);
  }

  //    prevent buttons from submiting
  document.querySelectorAll(`button`).forEach(btn => {
    btn.addEventListener("click", (e) => e.preventDefault());
  });

  //    question content transform to input
  quesText.addEventListener("click", function () {
    quesText.style.display = `none`;
    quesInput.value = quesText.innerText;
    quesInput.type = `text`;
    quesInput.focus();
  });

  //    question input transform to text 
  quesInput.addEventListener("blur", function () {
    quesInput.type = `hidden`;
    if (quesInput.value.length == 0) {
      quesText.innerText = quesInput.placeholder;
    }else {
      quesText.innerText = quesInput.value;
    }
    quesText.style.display = `block`;
  });
  
  //    delete answer
  answerContainer.querySelectorAll(`.delete-answer`).forEach(delBtn => {
  
    delBtn.addEventListener("click", function () {
      deleteAnswer(delBtn);
    });
  
  });

  //    check answer
  answerContainer.querySelectorAll(`.check-answer`).forEach(checkBtn => {
  
    checkBtn.addEventListener("click", function () {
      this.classList.toggle("active");
      if (this.classList.contains("active")) {
        this.parentElement.querySelector(`input[type="hidden"]`).value = 2;
      }else {
        this.parentElement.querySelector(`input[type="hidden"]`).value = 1;
      }
    });
  
  });

  //    delete answer
  function deleteAnswer(element) {
    if (answerContainer.querySelectorAll(`.answer`).length - 2 != 0) {
      element.parentElement.remove();
      // update inputs value
      answerContainer.querySelectorAll(`.answer[data-status="add"]`).forEach((inp, index) => {
        inp.querySelector(`input[type="hidden"]`).name = `answer[${index + 1}][is_right]`;
        let ans = inp.querySelector(`input.form-control`);
        ans.name = `answer[${index + 1}][answer]`;
        ans.placeholder = `Answer ${index + 1}`;
      });
    }
  }

}