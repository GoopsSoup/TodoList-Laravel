<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="register" style="border: 3px solid black">
            <h1>Register</h1>
            <form action="/register" method="POST">
                @csrf
                <input name="name" type="text" placeholder="Name" >
                <input name="email" type="text" placeholder="Email">
                <input name="password" type="password" placeholder="Password">
                <button>Register</button>
            </form>
        </div>
        <div class="login" style="border: 3px solid black">
            <h1>Login</h1>
            <form action="/login" method="POST">
                @csrf
                <input name="loginName" type="text" placeholder="Name" >
                <input name="loginEmail" type="text" placeholder="Email">
                <input name="loginPassword" type="password" placeholder="Password">
                <button>Log in</button>
            </form>
        </div>
</body>
</html>