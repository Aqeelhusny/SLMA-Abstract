//Path : app/Login.html
if (localStorage.getItem("screen") == "login") {
  const login_btn = document.getElementById("login_btn");
  login_btn.addEventListener("click", function () {
    login();
  });

  function login() {
    //const email = document.getElementById("email").value;
    //const password = document.getElementById("password").value;
    window.location.href = "/app/dashboard.html";
  }
}

//Path: app/dashboard.html

if (localStorage.getItem("screen") == "dashboard") {
  const track_submission_btn = document.getElementById("track_submission_btn");
  const submit_abstract_btn = document.getElementById("submit_abstract_btn");
  const user_profile_btn = document.getElementById("user_profile_btn");
  const contact_us_btn = document.getElementById("contact_us_btn");
  

  let dashboard_screens = ["track_submission", "submit_abstract","user_profile","contact_us"];

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

  user_profile_btn.addEventListener("click", function () {
    movePage("user_profile");
    
  });

  contact_us_btn.addEventListener("click", function () {
    movePage("contact_us");
    
  });

  movePage(dashboard_screens[0]);
}

console.log(location.search);
