let video = document.getElementById("video-viewr");

if (video) {

  let nextBtn = document.getElementById("next-btn");

  let xhr = new XMLHttpRequest();

  const params  = window.location.pathname.split("/");
  const course  = params[params.indexOf("view") + 1];
  const order   = params[params.indexOf("view") + 2];
  let sentBefore = false;
  

  function responseHandler(xhr) {
    const res = JSON.parse(xhr.response)
    if (res.success) {
      let copyParams = window.location.href.split("/");
      copyParams[copyParams.length-1] = +order + 1;
      let nextHref = copyParams.join("/");
      nextBtn.href = nextHref;
      nextBtn.classList.remove("disabled");
    }
  }


  video.addEventListener("ended", () => {
    
    if (!sentBefore) {

      xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState == 4) {
          responseHandler(xhr);
        }
      });
      
      let data = new FormData();
      
      data.append("course", course);
      data.append("order", order);
      
      xhr.open("POST", "http://localhost/dxnln/ar/lecture-done");
      
      xhr.send(data);
      
      
    }

    sentBefore = true;

  });

}