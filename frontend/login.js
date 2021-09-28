
    $(document).ready(function (){ // waiting for the document to be ready
        $("#login").on('click', function(){
            const email = $("#email").val();
            const password = $("#password").val();
            
            if(email == "" || password == ""){
                alert('One of the fields are empty');
            }
            else{
                $.ajax(
                    {
                        url: 'http://localhost/dashboard/comp1230/ASGMT_2_REDO/api/record/processLogin.php',
                        method: 'POST',
                        data:{
                            login: 1,
                            emailPHP: email,
                            passwordPHP: password
                        },
                        success: function(response){
                            console.log(response);
                            if(response.indexOf('success') >= 0 )
                            window.location = 'index.html';
                            else{
                                
                            }
                        },
                        dataType: 'text'
                    }
                )
            }
               
        })
    })

    // create a ajax call to a php file that checks if a session for the user exists or does not exist
  