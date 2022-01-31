/* bootstrap pooper enable */
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

import("./add-user.js");
import("./login.js");
import("./manage-answer.js");
import("./do-exam.js");
import("./lecture-done.js");
import("./item-manage.js");
import("./course-manage.js");
import("./group-icon.js");
import("./add-group-member.js");