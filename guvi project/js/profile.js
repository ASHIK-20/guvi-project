$(document).ready(function() {
    $('#updateButton').click(function() {
      var age = $('#age').val();
      var dob = $('#dob').val();
      var contact = $('#contact').val();
  
    
      $.ajax({
        url: 'profile.php',
        type: 'POST',
        data: {age: age, dob: dob, contact: contact},
        success: function(response) {
          alert(response);
        },
        error: function() {
          alert('Profile update failed. Please try again.');
        }
      });
    });
  });
  