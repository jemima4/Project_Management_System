$(() => {
  // Error message controllers
  const setMessage = (msg, alertType, id = "message") => {
    $(`p#${id}`).get(
      0
    ).innerHTML = `<span class='text-${alertType}'>${msg}</span>`;
  };
  const clearMessage = (id) =>
    setTimeout(() => {
      if (id) {
        setMessage("", "light", id);
      } else {
        setMessage("");
      }
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
        $.post(
          "./includes/loginprocessing.php",
          { adlogin: true, ademail: email, adpassword: password },
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

        // Change passwords here.
      } else if (loginType === "changestudent") {
        const pass = uid;
        const rePass = password;
        if (pass !== rePass) {
          setMessage("Passwords do not match!", "danger");
          clearMessage();
        } else {
          $.post(
            "./includes/studentprocessing.php",
            { stchangepass: true, newpassword: pass },
            function (data, status) {
              if (data.includes("changeSuccessful")) {
                setMessage(
                  "Password changed successfully. Reloading...",
                  "success"
                );
                setTimeout(
                  () => (window.location.href = "./dashboard.php"),
                  2000
                );
              } else {
                // Setting error message if there's one
                setMessage(data, "danger");
                clearMessage();
              }
            }
          );
        }
      } else if (loginType === "changelecturer") {
        const pass = uid;
        const rePass = password;
        if (pass !== rePass) {
          setMessage("Passwords do not match!", "danger");
          clearMessage();
        } else {
          $.post(
            "./includes/lecturerprocessing.php",
            { ltchangepass: true, newpassword: pass },
            function (data, status) {
              if (data.includes("changeSuccessful")) {
                setMessage(
                  "Password changed successfully. Reloading...",
                  "success"
                );
                setTimeout(
                  () => (window.location.href = "./dashboard.php"),
                  2000
                );
              } else {
                // Setting error message if there's one
                setMessage(data, "danger");
                clearMessage();
              }
            }
          );
        }
      }
    }
  });

  // Login password eye
  $(".form-group .fa").on("click", function () {
    const element = $(".pwd-group input");
    const type = $(".pwd-group input").attr("type");
    if (type === "password") {
      element.attr("type", "text");
      $(".form-group .fa").removeClass("fa-eye-slash");
      $(".form-group .fa").addClass("fa-eye");
    } else if (type === "text") {
      element.attr("type", "password");
      $(".form-group .fa").removeClass("fa-eye");
      $(".form-group .fa").addClass("fa-eye-slash");
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

    const uploadType = $(event.target).attr("type");

    if (uploadType === "newupload") {
      formData.append("ctproject", true);
    } else if (uploadType === "reupload") {
      formData.append("reupproject", true);
    }

    const projectName = $($(".create-form input")[0]).val();

    if (projectName === "" || $($(".create-form input")[1]).val() === "") {
      setMessage("Please fill in all fields", "danger");
      clearMessage();
    } else {
      $.ajax({
        xhr: function () {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener(
            "progress",
            function (evt) {
              if (evt.lengthComputable) {
                var percentComplete = (evt.loaded / evt.total) * 100;
                $(".progress-bar").width(percentComplete + "%");
                $(".progress-bar").html(percentComplete + "%");
              }
            },
            false
          );
          return xhr;
        },
        url: "./includes/studentprocessing.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
          $(".progress").show();
          $(".progress-bar").width("0%");
        },
        success: function (data, status, jqXHR) {
          if (data.includes("ProjectSuccessful")) {
            // Move to view project.
            setTimeout(
              () =>
                fetchProjectDetails("./includes/studentprocessing.php", {
                  fetchproject: true,
                }),
              500
            );
          } else {
            // Setting error message if there's one
            $(".progress-bar").html("Error");
            $(".progress-bar").addClass("bg-danger");
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

  // Handle moving to view project
  const fetchProjectDetails = (url, params) => {
    $.ajax({
      url: url,
      type: "POST",
      data: params,
      success: function (data, status, jqXHR) {
        if (data.includes("FetchSuccessful")) {
          // Move to view project.
          window.location.href = "./view.php";
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
  };

  // Handles students viewing project and lecturer viewing assigned students
  $(".view-project").on("click", function (event) {
    event.preventDefault();
    const currentUser = $(event.target).attr("type");
    if (currentUser === "lecturer") {
      fetchProjectDetails("./includes/lecturerprocessing.php", {
        vwstudents: true,
      });
    } else if (currentUser === "student") {
      fetchProjectDetails("./includes/studentprocessing.php", {
        fetchproject: true,
      });
    } else if (currentUser === "admin") {
      const target = $(event.target).attr("target");
      if (target === "students") {
        fetchProjectDetails("./includes/adminprocessing.php", {
          viewstudents: true,
        });
      } else if (target === "lecturers") {
        fetchProjectDetails("./includes/adminprocessing.php", {
          viewlecturers: true,
        });
      }
    }
  });

  // Lecturer viewing each student
  $(".view-student").on("click", function (event) {
    event.preventDefault();
    const projectId = $(event.target).attr("project");
    const student = $(event.target).attr("student");

    $.ajax({
      url: "./includes/lecturerprocessing.php",
      type: "POST",
      data: { fetchEach: true, projectId, student },
      success: function (data, status, jqXHR) {
        if (data.includes("FetchSuccessful")) {
          // Move to view project.
          window.location.href = "./editDocument.php";
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
  });

  // Lecturer grade form handler
  $("#grade-form input").on("keyup", function () {
    $("#grade-form button").removeClass("disabled");
  });

  $("#grade-form").on("submit", function (event) {
    event.preventDefault();
    const element = $("#grade-form")[0];
    const formData = new FormData(element);
    formData.append("gradeproject", true);

    const newgrade = $($("#grade-form input")[0]).val();

    if (newgrade.trim() === "") {
      setMessage("Please enter a grade!", "warning", "Gmessage");
      clearMessage();
    } else if (Number(newgrade) < 0 || Number(newgrade) > 100) {
      setMessage(
        "Please enter a valid grade (0 to 100)!",
        "warning",
        "Gmessage"
      );
      clearMessage();
    } else {
      $.ajax({
        url: "./includes/lecturerprocessing.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, status, jqXHR) {
          if (data.includes("graded")) {
            // reload on grade update
            window.location.reload();
          } else {
            // Setting error message if there's one
            setMessage(data, "danger", "Gmessage");
            clearMessage();
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(textStatus);
        },
      });
    }
  });

  // Handle add comment
  $(".comment-form").on("submit", function (e) {
    e.preventDefault();
    const element = $(".comment-form")[0];
    const formData = new FormData(element);
    formData.append("addcomment", true);

    const newComment = $($(".comment-form textarea")[0]).val();

    if (newComment.trim() === "") {
      setMessage("Please enter a comment!", "warning");
      clearMessage();
    } else {
      $.ajax({
        url: "./includes/studentprocessing.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, status, jqXHR) {
          if (data.includes("addCommentSuccesful")) {
            // Move to view project.
            window.location.reload();
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

  // Admin functionalities

  const processSubmission = (formData, op, msgField) => {
    $.ajax({
      url: "./includes/adminprocessing.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data, status, jqXHR) {
        if (
          data.includes("accountCreated") ||
          data.includes("accountUpdated")
        ) {
          // reload on account creation
          if (op === "edit") {
            setMessage(
              "Account updated successfully. Reloading...",
              "success",
              msgField
            );
            setTimeout(() => (window.location.href = "adminManage.php"), 2000);
          } else {
            setMessage(
              "Account created successfully. Reloading...",
              "success",
              msgField
            );
            setTimeout(() => window.location.reload(), 2000);
          }
        } else {
          // Setting error message if there's one
          setMessage(data, "danger", msgField);
          clearMessage();
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(textStatus);
      },
    });
  };

  // Create and edit student and lecturer

  $(".admin-form").on("submit", function (event) {
    event.preventDefault();
    const element = $(event.target)[0];
    const type = $(event.target).attr("type");
    const mode = $(event.target).attr("mode") != "" ? $(event.target).attr("mode") : false;
    const msgField = mode === "edit" ? "editMessage" : "message";

    // Checking for empty fields
    const inputValues = $(event.target).serializeArray();
    let empty = false;
    inputValues.every(({ value }, index) => {
      if (value === "") {
        empty = true;
        return false;
      } else {
        return true;
      }
    });

    // Grabbing passwords
    const password = $(".admin-form input[name='password']").val() != "" ? $(".admin-form input[name='password']").val() : true;
    const rePassword = $(".admin-form input[name='rePassword']").val() != "" ? $(".admin-form input[name='rePassword']").val() : true;

    // Parsing all form data
    const formData = new FormData(element);

    if (type === "Students") {
      if (mode === "edit") {
        formData.append("etstudent", true);
      } else {
        formData.append("ctstudent", true);
      }
    } else if (type === "Lecturers") {
      if (mode === "edit") {
        formData.append("etlecturer", true);
      } else {
        formData.append("ctlecturer", true);
      }
    }

    if (empty) {
      setMessage("Please fill in all fields!", "danger", msgField);
      clearMessage(msgField);
    } else if (password !== rePassword) {
      setMessage("Passwords do not match!", "danger", msgField);
      clearMessage(msgField);
    } else {
      processSubmission(formData, mode, msgField);
    }
  });
});
