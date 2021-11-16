let xhr = new XMLHttpRequest();
let video = document.getElementById("video-viewr");

function responseHandler(res) {
  if ( res.readyState == 4 && res.status == 200) {
    console.log(JSON.parse(res.response));
  }
}

const params  = window.location.pathname.split("/");
const course  = params[window.location.pathname.split("/").indexOf("view") + 1];
const order   = params[window.location.pathname.split("/").indexOf("view") + 2];

video.addEventListener("ended", function () {
  
  xhr.addEventListener("readystatechange", responseHandler(xhr));
  
  let data = new FormData();
  
  data.append("course", course);
  data.append("order", order);
  
  xhr.open("POST", "http://localhost/dxnln/ar/lecture-done");
  
  xhr.send(data);
  
});
