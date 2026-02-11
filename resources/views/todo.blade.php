<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @auth
        <p>You are logged in!</p>

        <h2>Create a new list</h2>
        <div>
            <form action="/create-list" method="POST">
                @csrf
                <input name="list" type="text" placeholder="Input list here">
                <button>Save List</button>
            </form>
        </div>

        <div style="border: 3px solid black">
            <h3>All Lists here</h3>
            @foreach ($posts as $post)
                <div style="border: 3px solid black">
                    <h4>{{$post['list']}}</h4>
                </div>
            @endforeach
        </div>

        <form action="/logout" method="POST">
            @csrf
            <button>Logout!</button>
        </form>
    @else
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
    @endauth
    
</body>
</html>