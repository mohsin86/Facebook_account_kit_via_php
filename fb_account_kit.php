<?php

// 
/*
 * successfull redirection checking
 * SIMPLE BASIC LOGIN
 *
 */
if(isset($_REQUEST["code"])){
    echo '<pre>';
    print_r($_REQUEST);
    echo '</pre>';
}


?>
<!DOCTYPE html>
<html>
<head>
  <title>Login with Account Kit</title>
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- HTTPS required. HTTP will give a 403 forbidden response -->
    <script src="https://sdk.accountkit.com/en_US/sdk.js"></script>

</head>
<body>


<?PHP
/*
 *  SIMPLE BASIC LOGIN
 *
 *
    <form method="get" action="https://www.accountkit.com/v1.0/basic/dialog/sms_login/">
        <input type="hidden" name="app_id" value="548301122336485">  <!--  YOUR_APP_ID -->
        <input type="hidden" name="redirect" value="https://dev.sebpo.net/theme.sebpo.net/AccountKit-Web-PHP/fb_account_kit.php
"> <!--  YOUR_REDIRECT_URL -->
        <input type="hidden" name="state" value="this_00_is_00_csrf_token_for_fb"> <!--  YOUR_CSRF_TOKEN  -->
        <input type="hidden" name="fbAppEventsEnabled" value=true>  <!--  fbAppEventsEnabled -->

        <input type="hidden" name="country_code" value="+880"> <!--  country_code  -->

        <button type="submit">SMS Login</button>
    </form>


    <form method="get" action="https://www.accountkit.com/v1.0/basic/dialog/email_login/">
        <input type="hidden" name="app_id" value="548301122336485"> <!--  YOUR_APP_ID -->
        <input type="hidden" name="redirect" value="https://dev.sebpo.net/theme.sebpo.net/AccountKit-Web-PHP/fb_account_kit.php
"> <!--  YOUR_REDIRECT_URL -->
        <input type="hidden" name="state" value="this_00_is_00_csrf_token_for_fb"> <!--  YOUR_CSRF_TOKEN -->
        <input type="hidden" name="fbAppEventsEnabled" value=true> <!--  YOUR_APP_ID  -->

        <input type="hidden" name="country_code" value="+880"> <!--  country_code  -->
        <button type="submit">email_Login</button>
    </form>
*/
 ?>


<!--
 +880 bD account login
-->

<input value="+880" id="country_code" readonly />
<input placeholder="phone number" id="phone_number"  />
<button onclick="smsLogin();">Login via SMS</button>
<div>OR</div>
<input placeholder="email" id="email"/>
<button onclick="emailLogin();">Login via Email</button>




<!--
 this is used for succefull login
-->
<form id="login_success" method="post" action="https://dev.sebpo.net/theme.sebpo.net/fb-accountkit-web/login_success.php">
    <input id="csrf" type="hidden" name="csrf" />
    <input id="code" type="hidden" name="code" />
</form>


<script>
    // initialize Account Kit with CSRF protection

    AccountKit_OnInteractive = function(){
        AccountKit.init(
            {
                appId:"548301122336485",
                state:"this_00_is_00_csrf_token_for_fb",
                version:"v1.1",
                fbAppEventsEnabled:true,
                redirect:"https://dev.sebpo.net/theme.sebpo.net/fb-accountkit-web/fb_account_kit.php
",  // will be redirect to this url after succesfull authentication, 
                debug:true
            }
        );
    };

    // login callback
    function loginCallback(response) {
        if (response.status === "PARTIALLY_AUTHENTICATED") {
            document.getElementById("code").value = response.code;
            document.getElementById("csrf").value = response.state;
            document.getElementById("login_success").submit();
            // Send code to server to exchange for access token
        }
        else if (response.status === "NOT_AUTHENTICATED") {
            // handle authentication failure
        }
        else if (response.status === "BAD_PARAMS") {
            // handle bad parameters
        }
    }

    // phone form submission handler
    function smsLogin() {
        var countryCode = document.getElementById("country_code").value;
        var phoneNumber = document.getElementById("phone_number").value;
        AccountKit.login(
            'PHONE',
            {countryCode: countryCode, phoneNumber: phoneNumber}, // will use default values if not specified
            loginCallback
        );
    }


    // email form submission handler
    function emailLogin() {
        var emailAddress = document.getElementById("email").value;
        AccountKit.login(
            'EMAIL',
            {emailAddress: emailAddress},
            loginCallback
        );
    }
</script>
</body>

</html>
