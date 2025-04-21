// Add task
$("#add-todo-btn").on("click", function () {
  const task = $("#task").val();

  if (task.trim() === "") {
    $("#error-field").text("Please enter a task name!");
    return;
  } else {
    $("#error-field").text("");
  }

  const dueDate = $("#due-date").val();
  const priority = $("#priority").val();
  const notes = $("#notes").val();

  const newRow = `
      <tr>
        <td><input type="checkbox" class="task-checkbox"></td>
        <td>${task}</td>
        <td>${dueDate}</td>
        <td>${priority}</td>
        <td>${notes}</td>
        <td>
            <button class="delete-btn"> 
                <img src="./assets/trash.png" alt="trash" />
            </button>
        </td>
      </tr>
    `;

  $("#todo-list-body").append(newRow);

  $("#task, #due-date, #notes").val("");
  $("#priority").val("Low");
});

// Change task status
$(document).on("change", ".task-checkbox", function () {
  $(this).closest("tr").toggleClass("completed");
});

// Delete task
$(document).on("click", ".delete-btn", function () {
  $(this).closest("tr").remove();
});

//Date & Time
function updateTimeAndDate() {
  const now = new Date();

  const hours = String(now.getHours()).padStart(2, "0");
  const minutes = String(now.getMinutes()).padStart(2, "0");
  const formattedTime = `${hours}:${minutes}`;

  const options = {
    weekday: "short",
    month: "short",
    day: "numeric",
    year: "numeric",
  };
  const formattedDate = now.toLocaleDateString("en-US", options);

  $("#time").text(formattedTime);
  $("#day").text(formattedDate);
}

$(document).ready(function () {
  updateTimeAndDate();
  setInterval(updateTimeAndDate, 60000);
});
