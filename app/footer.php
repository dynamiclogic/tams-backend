<script>
  $(function() {
    validateFields();
  });

  function checkPass() {
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('password');
    var pass2 = document.getElementById('confirm-password');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
      }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
      }
    }  

    function validateFields() {
      document.getElementById("create-btn").disabled = true;
      var password = document.getElementById('password').value;
      var confirmPasswod = document.getElementById('confirm-password').value;
      var firstname = document.getElementById('firstname').value;
      var username = document.getElementById('username').value;

      if (password != "" && firstname != "" && username != "" && password == confirmPasswod) {
        document.getElementById("create-btn").disabled = false;
      }

    }
  </script>

    <script type="text/javascript">
    	jQuery(document).ready(function($) {
    		$('.search-input').keyup(function(){
    			makeAjaxRequest();
    		});

            function makeAjaxRequest() {
                $.ajax({
                    url: 'search.php',
                    type: 'get',
                    data: {search: $('input#search').val()},
                    success: function(response) {
                      //if(screen.width > 767)
                        $('table#assets-table tbody').html(response);
                      //else
                        $('#mobile-assets-table').html(response);
                    }
                });
            }
    	});
    </script>

  </body>
</html>