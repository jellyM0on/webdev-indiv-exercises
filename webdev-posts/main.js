function getAll() {
  showSpinner();
  $.when(
    $.getJSON("https://jsonplaceholder.typicode.com/posts"),
    $.getJSON("https://jsonplaceholder.typicode.com/users")
  ).done(function (postsRes, usersRes) {
    const posts = postsRes[0];
    const users = usersRes[0];
    const userMap = {};
    users.forEach((user) => {
      userMap[user.id] = user;
    });
    const postsWithUsers = posts.map((post) => {
      return {
        ...post,
        user: userMap[post.userId],
      };
    });

    $("#results-container").empty();

    hideSpinner();
    postsWithUsers.forEach((post) => {
      displayPost(post);
    });
  });
}

function getById() {
  const postId = $("#postId").val().trim();
  const userId = $("#userId").val().trim();

  $("#results-container").empty();
  showSpinner();

  if (postId) {
    $.getJSON(
      `https://jsonplaceholder.typicode.com/posts/${postId}`,
      function (post) {
        $.getJSON(
          `https://jsonplaceholder.typicode.com/users/${post.userId}`,
          function (user) {
            post.user = user;
            displayPost(post);
            hideSpinner();
          }
        );
      }
    ).fail(function () {
      $("#results-container").append("<p>Post not found.</p>");
      hideSpinner();
    });
  } else if (userId) {
    $.getJSON(
      `https://jsonplaceholder.typicode.com/users/${userId}`,
      function (user) {
        $.getJSON(
          `https://jsonplaceholder.typicode.com/posts`,
          function (posts) {
            const userPosts = posts.filter((post) => post.userId == userId);

            if (userPosts.length > 0) {
              userPosts.forEach((post) => {
                post.user = user;
                displayPost(post);
              });
            } else {
              $("#results-container").append(
                "<p>No posts found for this User ID.</p>"
              );
            }
            hideSpinner();
          }
        );
      }
    ).fail(function () {
      $("#results-container").append("<p>User not found.</p>");
      hideSpinner();
    });
  } else {
    $("#results-container").append(
      "<p>Please enter a Post ID or User ID to search.</p>"
    );
    hideSpinner();
  }
}

function displayPost(post) {
  const postHtml = `
    <div class="post-card">
      <div class="post-header">
        <h3 class="post-title">#${post.id} - ${post.title}</h3>
      </div>
      <p class="post-body">${post.body}</p>
  
      <div class="user-info">
        <h4 class="user-name">${post.user.name} (@${post.user.username})</h4>
        <p><strong>Email:</strong> ${post.user.email}</p>
        <p><strong>Phone:</strong> ${post.user.phone}</p>
        <p><strong>Company:</strong> ${post.user.company.name}</p>
        <p><strong>Website:</strong> <a href="https://${post.user.website}" target="_blank">${post.user.website}</a></p>
      </div>
    </div>
  `;

  $("#results-container").append(postHtml);
}

function showSpinner() {
  $("#spinner-overlay").removeClass("hidden");
}

function hideSpinner() {
  $("#spinner-overlay").addClass("hidden");
}
