if (document.getElementById("add-member")) {
  let addMemberBtn  = document.getElementById("add-member");
  let membersTable  = document.getElementById("members-table");
  let selectShow    = false;

  addMemberBtn.addEventListener("click", function () {
    if (!selectShow) {

      selectShow = true;
      
      addMemberBtn.classList.add("unactive");
      
      let select = document.createElement("select");
      
      select.classList.add("mt-2", "form-control", "users-list", "unactive");

      setTimeout(() => {
        select.classList.remove("unactive");
      }, 1);

      addMemberBtn.parentElement.insertBefore(select, addMemberBtn);

      let xhr = new XMLHttpRequest();
  
      xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState == 4) {
          console.log(xhr.response);
          JSON.parse(xhr.response).forEach(member => {
            let option = document.createElement("option");
            option.value = member.id
            option.innerText = member.name
            select.append(option);
          });
        }
      });

      let data = new FormData();
  
      data.append("request", "get-addable-members");
      xhr.open("POST", "http://localhost/dxnln/ar/group-add-member/1");
      xhr.send(data);

      let optionBtns = document.createElement("div");
      optionBtns.classList.add("d-flex", "mt-3");

      let cancelBtn = document.createElement("button");
      cancelBtn.classList.add("btn", "btn-danger", "ml-1", "w-100");
      let timesSign = document.createElement("i");
      timesSign.classList.add("fas", "fa-times");
      cancelBtn.append(timesSign);
      optionBtns.append(cancelBtn);

      let saveBtn = document.createElement("button");
      saveBtn.classList.add("btn", "btn-success", "mr-1", "w-100");
      let saveSign = document.createElement("i");
      saveSign.classList.add("fas", "fa-save");
      saveBtn.append(saveSign);
      optionBtns.append(saveBtn);

      addMemberBtn.parentElement.insertBefore(optionBtns, addMemberBtn);

    }

  });
}