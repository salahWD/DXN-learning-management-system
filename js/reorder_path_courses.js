if (document.getElementById("path-courses-list")) {
  let courses         = document.querySelectorAll(".path_details .level-point");
  let dropContainers  = document.querySelectorAll(".path_details .drop-container");
  let dragableContainer;

  function resetClass(targetElements, removeClass = "active") {
    targetElements.forEach(el => {
      el.classList.remove(removeClass);
    });
  }
  function addClass(targetElements, addClass = "active") {
    targetElements.forEach(el => {
      el.classList.add(addClass);
    });
  }
  function revertCourses(containerOne, containerTow) {

    /* ======= Send Ajax Request Start ======= */

    let xhr           = new XMLHttpRequest();
    const url         = window.location.href.split("/");
    const groupId     = url[url.indexOf("dxnln") + 3];
    const courseId    = containerTow.querySelector(".level-point").dataset.id;
    
    let data          = new FormData();
    data.append("request", "reorder-course");
    data.append("course_id", courseId);
    data.append("new_order", containerOne.dataset.order);
    
    xhr.addEventListener("readystatechange", () => {
      if (xhr.readyState == 4) {
        console.log(xhr.response);
        let response = JSON.parse(xhr.response);
        if (response) {// every thing is alright on back-end
          /* =========== Update UI Start =========== */
          let one = containerOne.querySelector(".level-point");
          let tow = containerTow.querySelector(".level-point");
          one.classList.remove("active");
          tow.classList.remove("active");
          containerTow.append(one);
          containerOne.append(tow);
        }
      }
    });
    
    xhr.open("POST", `${theURL}/ar/path-course-manage/${groupId}`);
    xhr.send(data);

  }
  
  dropContainers.forEach(container => {
    /* ==========  Drag And Drop Start  ========== */
    container.addEventListener("dragover", function(e) {
      // prevent default to allow drop
      e.preventDefault();
    });
    container.addEventListener("drop", function(e) {
      e.preventDefault();
      revertCourses(this, dragableContainer);
    });

  });

  courses.forEach(course => {
    /* ==========  Drag And Drop Start  ========== */
    course.addEventListener("dragstart", function(e) {
      e.stopPropagation();
      dragableContainer = this.parentElement;
      addClass(document.querySelectorAll(".path_details .drop-container:not(#a" + this.id + ")"), "redy");
    });
    course.addEventListener("dragend", function(e) {
      e.stopPropagation();
      resetClass(dropContainers, "redy");
      dragableContainer = null;
    });
    /* ==========  Options Buttons Start  ========== */

    let can = true;// trigger to click on course to show options

    course.addEventListener("click", function(e) {
      e.stopPropagation();
      if (can) {
        can = false;
        this.classList.add("active");
        setTimeout(() => {
          course.classList.remove("active");
          can = true;
        }, 2000);
      }
    });
    
    course.querySelector('.delete-course-button').addEventListener("click", function () {
      let xhr           = new XMLHttpRequest();
      const url         = window.location.href.split("/");
      const groupId     = url[url.indexOf("dxnln") + 3];
      
      let data          = new FormData();
      data.append("request", "delete-course");
      data.append("group_id", groupId);

      xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState == 4) {
          console.log(xhr.response);
          let response = JSON.parse(xhr.response);
          if (response) {
            course.parentElement.remove();
          }
        }
      });
      
      xhr.open("POST", this.dataset.url);
      xhr.send(data);

    });
  });
}

window.addEventListener("keyup", function (e) {
  if (e.key == "Escape") {
    document.querySelectorAll(".path_details .level-point").forEach(course => {
      course.classList.remove("active");
    });
  }
});