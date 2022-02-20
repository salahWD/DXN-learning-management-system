if (document.getElementById("add-course-to-path-button")) {
  let addCourseBtn  = document.getElementById("add-course-to-path-button");
  let coursesList   = document.getElementById("path-courses-list");
  let error         = document.getElementById("path-error");
  let isActive      = false;
  const url         =  window.location.href.split("/");
  const group       =  url[url.indexOf("group-members") + 1];

  function makeElement(element, classes, id) {
    
    let item = document.createElement(element);
    item.id = id;
    item.classList.add(...classes);
    return item;
  }
  function createBtn(inner, ...classes) {
    let btn = document.createElement("button");
    btn.innerHTML = inner;
    btn.classList.add(...classes);
    return btn;
  }
  function createCourse(data) {
    let order = coursesList.querySelectorAll(".drop-container").length + 1;

    let container = document.createElement("div");
    container.classList.add("drop-container");
    container.dataset.order = order;

    let levelPoint = document.createElement("div");
    levelPoint.classList.add("level-point");
    levelPoint.draggable = "true";
    levelPoint.dataset.id = data.id;
    container.append(levelPoint);

    let controlList = document.createElement("div");
    controlList.classList.add("control-list");
    controlList.draggable = "true";
    levelPoint.append(controlList);

    let deleteBtn = document.createElement("button");
    deleteBtn.classList.add("delete-course-button", "btn", "btn-danger", "edit");
    deleteBtn.dataset.url = `${theURL}/ar/path-course-manage/${group}`;
    deleteBtn.innerHTML = '<i class="fas fa-trash" aria-hidden="true">';
    controlList.append(deleteBtn);

    let link = document.createElement("a");
    link.classList.add("circle");
    link.href = `${theURL}/ar/path-course-manage/${group}`;
    levelPoint.append(link);

    let span = document.createElement("span");
    span.innerHTML = order;
    link.append(span);

    let info = document.createElement("div");
    info.classList.add("info");
    levelPoint.append(info);

    let titleLink = document.createElement('a');
    titleLink.classList.add("text-decoration-none", "lead");
    titleLink.href = `${theURL}/ar/path-course-manage/${group}`;
    info.append(titleLink);

    let titleItem = document.createElement('p');
    titleItem.classList.add("title");
    titleItem.innerHTML = data.title;
    titleLink.append(titleItem);

    let desc = document.createElement('p');
    desc.classList.add("desc");
    desc.innerHTML = data.description;
    info.append(desc);

    return container;
  }

  addCourseBtn.addEventListener("click", function () {
    if (!isActive) {
      
      isActive = true;
      
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
              [select, optionBtns].forEach(e => {e.classList.add("unactive")});
              isActive = false;
              addCourseBtn.classList.remove("unactive");
            }

            addCourseBtn.classList.add("unactive");

            let select = makeElement("select", ["mt-2", "form-control", "items-list", "unactive"], "add-course-select");
            coursesList.insertBefore(select, addCourseBtn);
            
            setTimeout(() => {
              select.classList.remove("unactive");
            }, 0);// for fade in animation

            response.forEach(course => {
              let option = document.createElement("option");
              option.value = course.id
              option.innerText = course.title
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
              let selectCourse = document.getElementById("add-course-select");
              let form = new FormData();

              form.append("request", "add-course");
              form.append("course_id", selectCourse.value);

              let xhr = new XMLHttpRequest();
    
              xhr.addEventListener("readystatechange", () => {
                if (xhr.readyState == 4) {
                  const response = JSON.parse(xhr.response);
                  
                  if (response) {
                    error.classList.remove("show");

                    let title         = select.querySelector(`option[value="${selectCourse.value}"]`).innerHTML;
                    let id            = selectCourse.value;
                    let description   = selectCourse.value;
                    let course    = createCourse(response);
                    coursesList.insertBefore(course, coursesList.lastElementChild);
                  }else {
                    console.error("error while getting course info");
                  }

                }
              });

              xhr.open("POST", `${theURL}/ar/path-course-manage/${group}`);
              xhr.send(form);

              cancel();

            });
            
            coursesList.insertBefore(optionBtns, addCourseBtn);
            
            setTimeout(() => {// for fade in animation
              optionBtns.classList.remove("unactive");
            }, 0);

          }else {// if no addable courses avalible button will be red and contain an error msg
            let errorArea = addCourseBtn.querySelector("span");
            errorArea.setAttribute("data-text", errorArea.innerText);
            errorArea.innerText = errorArea.dataset.error;
            addCourseBtn.classList.add("border-danger", "btn-danger");
            setTimeout(() => {
              addCourseBtn.classList.remove("border-danger", "btn-danger");
              isActive = false;// to be able to press the button again
              errorArea.innerText = errorArea.dataset.text;
            }, 2500);
            console.error("no addable records");
          }
        }
      });
      
      let data = new FormData();
      data.append("request", "get-addable-courses");
      xhr.open("POST", `${theURL}/ar/path-course-manage/${group}`);
      xhr.send(data);

    }
  });

}