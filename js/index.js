$(() => {
  $(".login-form").on("submit", function (e) {
    e.preventDefault();
    const element = $($(".login-form")[0]);
    const loginType = element.attr("type");

    const uid = $($(".login-form input")[0]).val();
    const password = $($(".login-form input")[1]).val();

    if (uid === "" || password === "") {
      $("p#message").get(0).innerHTML =
        "<span class='text-danger'>Please fill in all fields!</span>";
    
      setTimeout(() => {
        $("p#message").get(0).innerHTML = "";
      }, 3000);
    } else {
        if (loginType === "Lecturer") {
            const email = uid;

        } else if (loginType === "Student") {
            const matricNo = uid;

        } else if (loginType === "Admin") {
            const email = uid;
            
        }
    }
  });
});
