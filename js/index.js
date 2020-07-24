$(() => {
  const setMessage = (msg, alertType) => {
    $("p#message").get(
      0
    ).innerHTML = `<span class='text-${alertType}'>${msg}</span>`;
  };
  $(".login-form").on("submit", function (e) {
    e.preventDefault();
    const element = $($(".login-form")[0]);
    const loginType = element.attr("type");

    const uid = $($(".login-form input")[0]).val();
    const password = $($(".login-form input")[1]).val();

    if (uid === "" || password === "") {
      setMessage("Please fill in all fields", "danger");
      setTimeout(() => {
        setMessage("");
      }, 3000);
    } else {
      if (loginType === "Lecturer") {
        const email = uid;
        window.location.href = "dashboard.php";
      } else if (loginType === "Student") {
        const matricNo = uid;
        window.location.href = "dashboard.php";
      } else if (loginType === "Admin") {
        const email = uid;
        window.location.href = "dashboard.php";
      }
    }
  });
});
