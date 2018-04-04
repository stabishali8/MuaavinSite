$(document).ready(function(){
    $(".userresponse").validate({
        rules: {
            name: {
                required: true,
                minlength: 4
            },
            email: {
                required:true,
                email:true 
            },
            message: {
                required: true
            }
        },
        messages:{
            name:{
               required: "Name is required" 
            },
            email:{
               required: "Email is required" 
            },
            message:"Message is required"
                                        
        }
    });

});