$(() => {
  const setMessage = (msg, alertType) => {
    $("p#message").get(
      0
    ).innerHTML = `<span class='text-${alertType}'>${msg}</span>`;
  };
  const clearMessage = () =>
    setTimeout(() => {
      setMessage("");
    }, 3000);
  $(".login-form").on("submit", function (e) {
    e.preventDefault();
    const element = $($(".login-form")[0]);
    const loginType = element.attr("type");

    const uid = $($(".login-form input")[0]).val();
    const password = $($(".login-form input")[1]).val();

    if (uid === "" || password === "") {
      setMessage("Please fill in all fields", "danger");
      clearMessage();
    } else {
      if (loginType === "Lecturer") {
        const email = uid;
        // Making request to php file with data passed.
        $.post(
          "./includes/loginprocessing.php",
          { ltlogin: true, ltemail :email, ltpassword: password },
          function (data, status) {
            if (data.includes("loginSuccessful")) {
              // Move to dashboard.
              window.location.href = "./dashboard.php?u=lecturer";
            } else {
              // Setting error message if there's one
              setMessage(data, "danger");
              clearMessage();
            }
          }
        );
      } else if (loginType === "Student") {
        const matricNo = uid;
        // Making request to php file with data passed.
        $.post(
          "./includes/loginprocessing.php",
          { stlogin: true, matricNo, stpassword: password },
          function (data, status) {
            if (data.includes("loginSuccessful")) {
              // Move to dashboard.
              window.location.href = "./dashboard.php";
            } else {
              // Setting error message if there's one
              setMessage(data, "danger");
              clearMessage();
            }
          }
        );
      } else if (loginType === "Admin") {
        const email = uid;
        // Process info to backend
      }
    }
  });
});
