$(document).ready(function(){

  const checkBtn  = $(`#send`);
  let   answers   = $(`.question-show`);

  checkBtn.click(function () {
    answers.each(function (i, inp) {
      
      if (inp.querySelectorAll("input").length == 0) {
        inp.addClass("border-danger", "border", "rounded");
        $("this").find(`.question-text`).addClass("text-danger");
      }else {
        inp.removeClass("border-danger");
        $("this").find(`.question-text`).removeClass("text-danger");
      }
    });

    if ($(`.question-show.border-danger`).length > 0) {
      window.scroll({
        top: $(`.question-show.border-danger`)[0].offset().top - 40,
        left: 100,
        behavior: 'smooth'
      });
    }else {
      // document.forms[0]

    }

  });
});