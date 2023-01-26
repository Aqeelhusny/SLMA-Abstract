//Path : View/Login.html
if (localStorage.getItem("screen") == "login") {
  const login_btn = document.getElementById("login_btn");
  login_btn.addEventListener("click", function () {
    login();
  });

  function login() {
    //const email = document.getElementById("email").value;
    //const password = document.getElementById("password").value;
    window.location.href = "/View/dashboard.html";
  }
}

//Path: View/dashboard.html

if (localStorage.getItem("screen") == "dashboard") {
  const track_submission_btn = document.getElementById("track_submission_btn");
  const submit_abstract_btn = document.getElementById("submit_abstract_btn");

  let dashboard_screens = ["track_submission", "submit_abstract"];

  function movePage(screen_id) {
    for (let index = 0; index < dashboard_screens.length; index++) {
      const element = document.getElementById(dashboard_screens[index]);
      const element_btn = document.getElementById(
        dashboard_screens[index] + "_btn"
      );
      element.style.display = "none";
      element_btn.classList.remove("active");
    }
    document.getElementById(screen_id).style.display = "block";
    document.getElementById(screen_id + "_btn").classList.add("active");
  }

  track_submission_btn.addEventListener("click", function () {
    movePage("track_submission");
  });

  submit_abstract_btn.addEventListener("click", function () {
    movePage("submit_abstract");
  });

  movePage(dashboard_screens[0]);
}
