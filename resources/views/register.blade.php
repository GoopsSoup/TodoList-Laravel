<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body class="p-0 m-0">

    {{-- register page --}}
    <section class="h-130 flex justify-center m-8">
        <div class="bg-red-600 flex w-auto"> 
            <div class="bg-emerald-400 w-120 flex justify-center items-center rounded-br-3xl rounded-tr-3xl ">
                <img src="/images/thejonkler.jpg" alt="The real jonkler" class="w-full h-full p-2 rounded-tr-4xl rounded-br-4xl">
            </div>
            <div class="w-120 flex flex-col items-center justify-center">
                <h1 class="text-3xl relative">Register</h1>
                <form action="/register" method="POST" class="flex flex-col gap-5 pt-9 w-70">
                    @csrf
                    <p class="h-0.5">Name</p>
                    <input name="name" type="text" placeholder="username" class="bg-fuchsia-400 border-2 h-10 pl-1">
                    <p class="h-0.5">Email</p>
                    <input name="email" type="text" placeholder="user@gmail.com" class="bg-fuchsia-400 border-2 h-10 pl-1">
                    <p class="h-0.5">Password</p> 
                    <input name="password" type="password" class="bg-fuchsia-400 border-2 h-10 pl-1">
                    <div class="flex justify-center items-center">
                        <button class="bg-cyan-600 border-2 h-12 w-70 ">Register</button>
                    </div>
                    <p class="text-center">Already have an account? <a href="">Login</a></p>
                </form>
            </div>
        </div>
    </section>

        {{-- login page --}}
    <section class="h-130 flex justify-center m-8">
        <div class="bg-red-600 flex w-auto"> 
            <div class="w-120 flex flex-col items-center justify-center">
                <h1 class="text-3xl relative">Login</h1>
                <form action="/login" method="POST" class="flex flex-col gap-5 pt-9 w-70">
                    @csrf
                    <p class="h-0.5">Name</p>
                    <input name="loginName" type="text" placeholder="username" class="bg-fuchsia-400 border-2 h-10 pl-1">
                    <p class="h-0.5">Email</p>
                    <input name="loginEmail" type="text" placeholder="user@gmail.com" class="bg-fuchsia-400 border-2 h-10 pl-1">
                    <p class="h-0.5">Password</p> 
                    <input name="loginPassword" type="password" class="bg-fuchsia-400 border-2 h-10 pl-1">
                    <div class="flex justify-center items-center">
                        <button class="bg-cyan-600 border-2 h-12 w-70 ">Log in</button>
                    </div>
                    <p class="text-center">Don't have an account? <a href="">Register</a></p>
                </form>
            </div>
            <div class="bg-emerald-400 w-120 flex justify-center items-center rounded-bl-3xl rounded-tl-3xl ">
                <img src="/images/thejonkler.jpg" alt="The real jonkler" class="w-full h-full p-2 rounded-tl-4xl rounded-bl-4xl">
            </div>
        </div>
    </section>
</body>
</html>

{{-- 
<form action="/login" method="POST" class="flex flex-col">
                @csrf
                <input name="loginName" type="text" placeholder="Name" >
                <input name="loginEmail" type="text" placeholder="Email">
                <input name="loginPassword" type="password" placeholder="Password">
                <button class="bg-cyan-600 w-20">Log in</button>
            </form> 
            --}}