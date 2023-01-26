const track_submission_btn = document.getElementById("track_submission_btn");
const submit_abstract_btn = document.getElementById("submit_abstract_btn");

let dashboard_screens = ["track_submission","submit_abstract"]

function movePage(screen_id) {
    for (let index = 0; index < dashboard_screens.length; index++) {
        const element = document.getElementById(dashboard_screens[index]);
       element.style.display = "none";
       element.classList.remove("active");
    }
    document.getElementById(screen_id).style.display = "block";
    document.getElementById(screen_id).classList.add("active");
    
}

track_submission_btn.addEventListener("click",function () {
    movePage("track_submission")});
submit_abstract_btn.addEventListener("click",function () {
    movePage("submit_abstract")
    
});



movePage(dashboard_screens[0]);