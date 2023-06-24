$(document).ready(function() {
    $('#signupButton').click(function() {
      var username = $('#username').val();
      var password = $('#password').val();
  
      // Send signup request
      $.ajax({
        url: 'register.php',
        type: 'POST',
        data: {username: username, password: password},
        success: function(response) {
          alert(response);
          window.location.href = 'login.html'; // Redirect to login page
        },
        error: function() {
          alert('Signup failed. Please try again.');
        }
      });
    });
  });
  