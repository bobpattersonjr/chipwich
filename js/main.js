$(document).ready(function(){
    jQuery("abbr.timeago").timeago();

    $('.editable').editable();

    jQuery.validator.addMethod(
        "over18",
        function(value, element) {
            var check = false;
            var dob = Date.parse(value);
            if (dob.addYears(18) < Date.today()){
                check = true;
            }else{
                check = false;
            }
            return this.optional(element) || check;
        },
        "You have to over 18 to sign up"
    );

    jQuery.validator.addMethod(
        "dateUS",
        function(value, element) {
            var check = false;
            var re = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
            if( re.test(value)){
                var adata = value.split('/');
                var mm = parseInt(adata[0],10);
                var dd = parseInt(adata[1],10);
                var yyyy = parseInt(adata[2],10);
                var xdata = new Date(yyyy,mm-1,dd);
                if ( ( xdata.getFullYear() == yyyy ) && ( xdata.getMonth () == mm - 1 ) && ( xdata.getDate() == dd ) )
                    check = true;
                else
                    check = false;
            } else
                check = false;
            return this.optional(element) || check;
        },
        "Please enter a date in the format mm/dd/yyyy"
    );

    // Validation
    $("#signup_form").validate({
        rules:{
            first_name:"required",
            last_name:"required",
            email:{required:true,email: true},
            password:{required:true,minlength: 6},
            gender:"required",
            dob: {required: true, dateUS: true, over18: true},
            tos:"required",
        },

        messages:{
            first_name:"Enter your first name",
            last_name:"Enter your last name",
            email:{
                required:"Enter your email address",
                email:"Enter valid email address"},
            password:{
                required:"Enter your password",
                minlength:"Password must be minimum 6 characters"},
            gender:"Select Gender",
            tos:"Please read then select the text box"

        },

        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass){
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass){
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        },
        submitHandler: function(form) {
            $.post("/account/create",
                $("#signup_form").serialize(),
                function(data){
                    if (data['success']){
                        location.reload(true);
                    }else{
                        $('#signup-error').show();
                        $("#alert_area_signup").append($('<div id="signup-error" class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Sign Up Error</strong></div>'));
                    }
                }, 
                "json");
        }
    });

    $("#login_form").validate({
        rules:{
            email:{required:true,email: true},
            password:{required:true,minlength: 6}
        },

        messages:{
            email:{
                required:"Enter your email address",
                email:"Enter valid email address"},
            password:{
                required:"Enter your password",
                minlength:"Password must be minimum 6 characters"}
        },

        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass){
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass){
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        },
        submitHandler: function(form) {
            $.post("/account/login",
                $("#login_form").serialize(),
                function(data){
                    if (data['success'])
                        location.reload(true);
                    else
                        $("#alert_area_login").append($('<div id="login-error" class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Invaild Login</strong></div>'));
                }, 
                "json");
        }
    });
      
});