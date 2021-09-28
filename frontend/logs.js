$(document).ready(function(){
    // check if the user is logged in 
    $.ajax(
        {
            url: 'http://localhost/dashboard/comp1230/ASGMT_2_REDO/api/record/processLogin.php',
        }
    )
})