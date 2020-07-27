$(() => {
  // Error message controllers
  const setMessage = (msg, alertType) => {
    $("p#message").get(
      0
    ).innerHTML = `<span class='text-${alertType}'>${msg}</span>`;
  };
  const clearMessage = () =>
    setTimeout(() => {
      setMessage("");
    }, 3000);

  // Login forms processing
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
      // Lecturer login handler
      if (loginType === "Lecturer") {
        const email = uid;
        // Making request to php file with data passed.
        $.post(
          "./includes/loginprocessing.php",
          { ltlogin: true, ltemail: email, ltpassword: password },
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
        // Student login handler
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
        // Admin login handler
      } else if (loginType === "Admin") {
        const email = uid;
        // Process info to backend
      }
    }
  });

  // Logout handler
  $("#logoutUser").on("click", function (e) {
    e.preventDefault();
    $.post("./includes/loginprocessing.php", { logoutUser: true }, function (
      data,
      status
    ) {
      if (data.includes("logoutSuccessful")) {
        // Move to home page.
        window.location.href = "./index.php";
      } else {
        alert("An error occurred while logging out");
        alert(data);
      }
    });
  });

  // File upload handler
  $(".create-form").on("submit", function (e) {
    e.preventDefault();
    const element = $(".create-form")[0];
    const formData = new FormData(element);
    formData.append("ctproject", true);

    const projectName = $($(".create-form input")[0]).val();
    const fileData = $($(".create-form input")[1]).prop("files");

    if (projectName === "" || fileData === "") {
      setMessage("Please fill in all fields", "danger");
      clearMessage();
    } else {
      $.ajax({
        url: "./includes/studentprocessing.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, status, jqXHR) {
          if (data.includes("ProjectSuccessful")) {
            setMessage(
              "Project created successfully! View page under construction",
              "success"
            );
            // Move to view project.
            // window.location.href = "./view.php";
          } else {
            // Setting error message if there's one
            setMessage(data, "danger");
            clearMessage();
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(textStatus);
        },
      });
    }
  });
});
