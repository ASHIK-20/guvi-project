$(document).ready(function() {
    $('#loginButton').click(function() {
      var username = $('#username').val();
      var password = $('#password').val();
  
      
      $.ajax({
        url: 'login.php',
        type: 'POST',
        data: {username: username, password: password},
        success: function(response) {
          localStorage.setItem('isLoggedIn', 'true'); 
          window.location.href = 'profile.html'; 
        },
        error: function() {
          alert('Login failed. Please try again.');
        }
      });
    });
  });
  