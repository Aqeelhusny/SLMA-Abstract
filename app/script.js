const URL = "http://127.0.0.1:8000/";
const DASHBOARD = "/app/dashboard.html";
const LOGIN = "/app/login.html";
const REGISTER = "/app/register.html";
let alertWindow;

//Path : app/Login.html
if (localStorage.getItem("screen") == "login") {
  const login_form = document.getElementById("login_form");
  login_form.addEventListener("submit", async function (e) {
    e.preventDefault();
    const email = e.target.email.value;
    const password = e.target.password.value;
    await fetch(URL + "api/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: email,
        password: password,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data["response"]["status"] == 200) {
          window.location.href = DASHBOARD;
        } else if (data["response"]["status"] == 404) {
          alertWindow(data["response"]["message"], "danger");
        } else {
          alertWindow("Something went wrong", "danger");
        }
      });
  });
}

//Path : app/Register.html
if (localStorage.getItem("screen") == "register") {
  const register_form = document.getElementById("signup_form");
  let registrationData = {};
  const verificationModal = document.getElementById("verificationModal");
  const verificationCodeField = document.getElementById("verification_code");
  const resendCodeBtn = document.getElementById("resend_code");
  const registerBtn = document.getElementById("finish_registration");

  register_form.addEventListener("submit", async function (e) {
    e.preventDefault();
    registrationData = {
      title: e.target.title.value,
      email: e.target.email.value,
      password: e.target.password.value,
      first_name: e.target.first_name.value,
      last_name: e.target.last_name.value,
      qualification: e.target.qualification.value,
      phone: e.target.phone.value,
      whatsapp_no: e.target.whatsapp_no.value,
      landline_no: e.target.landline_no.value,
      designation: e.target.designation.value,
      affiliation: e.target.affiliation.value,
      home_address: e.target.home_address.value,
      office_address: e.target.office_address.value,
      verificationCode: 0,
    };

    await fetch(URL + "api/sendVerificationEmail", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email: e.target.email.value }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data["response"]["status"] == 200) {
          registrationData.verificationCode =
            data["response"]["verification_code"];
          $(verificationModal).modal("show");
        } else {
          if (alertWindow) {
            alertWindow(data["response"]["message"], "danger");
          }
        }
      });
  });

  verificationModal.addEventListener("shown.bs.modal", async () => {
    if (alertWindow) {
      alertWindow("Verfication Code sent to your email", "success");
      console.log(
        "Verfication Code sent to your email " +
          registrationData.verificationCode
      );
    }
  });

  registerBtn.addEventListener("click", async function (e) {
    e.preventDefault();
    if (verificationCodeField.value == registrationData.verificationCode) {
      await fetch(URL + "api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(registrationData),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data["response"]["status"] == 201) {
            window.location.href = LOGIN;
          } else {
            if (alertWindow) {
              alertWindow(data["response"]["message"], "danger");
            }
          }
        });
    } else {
      alertWindow("Verification code is incorrect", "danger");
    }
  });
}

//Path: app/dashboard.html

if (localStorage.getItem("screen") == "dashboard") {
  const track_submission_btn = document.getElementById("track_submission_btn");
  const submit_abstract_btn = document.getElementById("submit_abstract_btn");
  const user_profile_btn = document.getElementById("user_profile_btn");
  const contact_us_btn = document.getElementById("contact_us_btn");

  let dashboard_screens = [
    "track_submission",
    "submit_abstract",
    "user_profile",
    "contact_us",
  ];

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

const alertPlaceholder = document.getElementById("liveAlertPlaceholder");
if (alertPlaceholder) {
  alertWindow = (message, type) => {
    const wrapper = document.createElement("div");
    wrapper.innerHTML = [
      `<div class="alert alert-${type} alert-dismissible" role="alert">`,
      `   <div>${message}</div>`,
      '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
      "</div>",
    ].join("");

    alertPlaceholder.append(wrapper);
  };
}
