<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
        body{
            background: #ECECEC;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        }
        #header{
            background: #6C6C6C;
            color:white;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        #header h1{
            text-align: center;
        }
        #content{
            text-align: center;
        }
        #content p {
            padding-top: 30px;
            padding-bottom: 30px;
        }
        #content a {
            background: #AC0B0B;
            color:white;
            padding: 10px;
            text-decoration: none;

        }
        #content a:hover{
            background: white;
            color: #AC0B0B;
        }
        #footer{
            text-align: center;
        }
        #footer p {
            font-size:12px;
        }
        #footer .footer-p{
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div id="header">
        <h1>Reset password</h1>
    </div>
    <div id="content">
        <p>You are receiving this email because we received a password reset request for your account.</p>
        <a href="{{ $actionUrl }}" target="_blank">Reset password</a>
        <p>If you did not request a password reset, no further action is required.</p>

    </div>
    <hr>
    <div id="footer">
        <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <br><a href="{{ $actionUrl }}">{{ $actionUrl }}</a></p>
        <p class="footer-p">Copyright &copy; {{ url('/').' '.date('Y') }} </p>
    </div>
</body>
</html>
