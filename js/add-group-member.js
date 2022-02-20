if (document.getElementById("add-member")) {
  let addMemberBtn  = document.getElementById("add-member");
  let membersTable  = document.getElementById("members-table");
  let rows          = document.querySelectorAll(`#members-table .table-row`);
  let selectShow    = false;
  let error         = document.getElementById("user-error")
  const url         = window.location.href.split("/");
  const group       = url[url.indexOf("dxnln") + 3];

  function createBtn(inner, ...classes) {
    let btn = document.createElement("button");
    btn.innerHTML = inner;
    btn.classList.add(...classes);
    return btn;
  }

  function createRow(id, memberId, fullname, percent) {
    let row = document.createElement("div");
    row.className = "table-row";

    let idCell = document.createElement("div");
    idCell.classList.add("cell", "id");
    idCell.setAttribute("data-id", memberId);
    idCell.innerText = id;
    row.appendChild(idCell);
    
    let nameCell = document.createElement("div");
    nameCell.classList.add("cell", "name");
    nameCell.innerText = fullname;
    row.appendChild(nameCell);

    let percentCell = document.createElement("div");
    percentCell.classList.add("cell", "percent");
    percentCell.innerText = `${percent}%`;
    row.appendChild(percentCell);

    let controlCell = document.createElement("div");
    controlCell.classList.add("cell", "control");
    row.appendChild(controlCell);

    let deleteBtn = document.createElement("button");
    deleteBtn.classList.add("btn", "btn-danger");
    deleteBtn.innerHTML = `<i class="fas fa-trash"></i>`;
    controlCell.appendChild(deleteBtn);

    deleteBtn.addEventListener("click", function () {
      deleteMember(this);
    });

    return row;
  }

  function deleteMember(button) {
    const memberId = button.parentElement.parentElement.querySelector('.id').dataset.id;
    if (true) {// confairm function will replace "true" place in condition
      
      let xhr = new XMLHttpRequest();

      xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState == 4) {
          const response = JSON.parse(xhr.response);
          if (response) {
            button.parentElement.parentElement.style.height = `${button.parentElement.parentElement.offsetHeight}px`;
            setTimeout(() => {
              button.parentElement.parentElement.style.height = "0px";
            }, 50);
            setTimeout(() => {
              button.parentElement.parentElement.remove();
              if (document.querySelectorAll(`#members-table .table-row`).length <= 1) {
                error.classList.add("show");
              }else {
                console.log(document.querySelectorAll(`#members-table .table-row`));
              }
            }, 1000);
          }
        }
      });
      
      let data = new FormData();
      data.append("request", "delete-member");
      data.append("member_id", memberId);
      xhr.open("POST", `${theURL}/ar/group-add-member/${group}`);
      xhr.send(data);

    }
  }

  if (rows.length > 1) {
    let members = membersTable.querySelectorAll(".table-row .control .delete-btn");
    members.forEach(btn => {
      btn.addEventListener("click", function () {
        deleteMember(this);
      });
    });
  }

  addMemberBtn.addEventListener("click", function () {
    if (!selectShow) {
      
      selectShow = true;
      
      let xhr = new XMLHttpRequest();
  
      xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState == 4) {
          const response = JSON.parse(xhr.response);
          if (Array.isArray(response) && response.length > 0) {

            function cancel() {
              setTimeout(() => {
                select.remove();
                optionBtns.remove();
              }, 1000);
              select.classList.add("unactive");
              optionBtns.classList.add("unactive");
              addMemberBtn.classList.remove("unactive");
              selectShow = false;
            }

            addMemberBtn.classList.add("unactive");

            let select = document.createElement("select");
            select.id = 'add-user-select';
            select.classList.add("mt-2", "form-control", "items-list", "unactive");
            membersTable.insertBefore(select, addMemberBtn);
            
            setTimeout(() => {
              select.classList.remove("unactive");
            }, 1);// for fade in animation

            response.forEach(member => {
              let option = document.createElement("option");
              option.value = member.student_id
              option.innerText = member.fullname
              select.append(option);
            });

            let optionBtns = document.createElement("div");
            optionBtns.classList.add("d-flex", "mt-3", "unactive", "option-button-container");

            let cancelBtn = createBtn(`<i class="fas fa-times"></i>`, "btn", "btn-danger", "ml-1", "w-100", "d-flex", "align-items-center", "justify-content-center");
            optionBtns.append(cancelBtn);

            cancelBtn.addEventListener("click", function () {
              cancel();
            });
            
            let saveBtn = createBtn(`<i class="fas fa-save"></i>`,"btn", "btn-success", "mr-1", "w-100", "d-flex", "align-items-center", "justify-content-center");
            optionBtns.append(saveBtn);

            saveBtn.addEventListener("click", function () {
              let addUserSelect = document.getElementById("add-user-select");
              let form = new FormData();

              form.append("request", "add-member");
              form.append("member_id", addUserSelect.value);

              let xhr = new XMLHttpRequest();
    
              xhr.addEventListener("readystatechange", () => {
                if (xhr.readyState == 4) {
                  const response = JSON.parse(xhr.response);
                  console.log(response);
                  error.classList.remove("show");
                  if (response) {

                    let id = rows.length;
                    let fullname = addUserSelect.querySelector(`option[value="${addUserSelect.value}"]`).text;
                    membersTable.insertBefore(createRow(id, addUserSelect.value, fullname, Math.floor(Math.random() * 100)), membersTable.lastElementChild);
    
                  }else {
                    console.error("error while adding member");
                  }
                }
              });

              xhr.open("POST", `${theURL}/ar/group-add-member/${group}`);
              xhr.send(form);

              cancel();

            });
            
            membersTable.insertBefore(optionBtns, addMemberBtn);
            
            setTimeout(() => {// for fade in animation
              optionBtns.classList.remove("unactive");
            }, 1);

          }else {// button will be red and contain an error msg
            let errorArea = addMemberBtn.querySelector("span");
            errorArea.setAttribute("data-text", errorArea.innerText);
            errorArea.innerText = errorArea.dataset.error;
            addMemberBtn.classList.add("border-danger", "btn-danger");
            setTimeout(() => {
              addMemberBtn.classList.remove("border-danger", "btn-danger");
              selectShow = false;// to be able to press the button again
              errorArea.innerText = errorArea.dataset.text;
            }, 2500);
          }
        }
      });
      
      let data = new FormData();
      data.append("request", "get-addable-members");
      xhr.open("POST", `${theURL}/ar/group-add-member/${group}`);
      xhr.send(data);

    }
  });
}