<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to PBIT, {{$user->name }}</h2>
<br/>
Your registered email-id is {{$user->email}} , Please click on the below link to verify your email account
<br/>
<a style="color: blue;" href="{{url('user/verify/'.$user->remember_token)}}">Verify Email</a>
</body>

</html>