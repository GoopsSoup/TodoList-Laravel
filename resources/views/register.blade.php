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

    <section class="flex items-center justify-center min-h-screen bg-amber-50">

        <div class="">

            {{-- Register/Login page --}}
            <div class="h-130 flex justify-center w-full md:w-[62.5vw] max-w-5xl"> 
                    
                <div class="flex flex-col md:flex-row w-full"> 

                    <div class="relative bg-emerald w-full flex justify-center items-center bg-fuchsia-600">
                        <img id="imageslider" src="/images/thejonkler.jpg" alt="The real jonkler" 
                        class="w-full h-full     rounded-tr-4xl rounded-br-4xl z-2 transition-all ease-in-out duration-700">

                        <div class="flex flex-col items-center justify-center absolute">

                            <h1 class="text-3xl relative">Login</h1>

                            <form action="/login" method="POST" class="flex flex-col gap-3 pt-9 w-70">
                                @csrf
                                <p class="text-sm">Name</p>
                                <input name="loginName" type="text" placeholder="username" class="bg-fuchsia-400 border-2 h-10 pl-1 w-full">
                                <p class="text-sm">Email</p>
                                <input name="loginEmail" type="text" placeholder="user@gmail.com" class="bg-fuchsia-400 border-2 h-10 pl-1 w-full">
                                <p class="text-sm">Password</p> 
                                <input name="loginPassword" type="password" class="bg-fuchsia-400 border-2 h-10 pl-1 w-full">
                                <div class="flex justify-center items-center">
                                    <button class="bg-cyan-600 border-2 h-12 w-full">Log in</button>
                                </div>  
                                <p class="text-center">Don't have an account? <a href="#" onclick="showRegister()">Register</a></p>
                            </form>

                        </div>
                    </div>

                    <div class="w-full flex flex-col items-center justify-center bg-fuchsia-600">

                        <h1 class="text-3xl relative">Register</h1>

                        <form action="/register" method="POST" class="flex flex-col gap-3 pt-9 w-70">
                            @csrf
                            <p class="text-sm">Name</p>
                            <input name="name" type="text" placeholder="username" class="bg-fuchsia-400 border-2 h-10 pl-1 w-full">
                            <p class="text-sm">Email</p>
                            <input name="email" type="text" placeholder="user@gmail.com" class="bg-fuchsia-400 border-2 h-10 pl-1 w-full">
                            <p class="text-sm">Password</p> 
                            <input name="password" type="password" class="bg-fuchsia-400 border-2 h-10 pl-1 w-full">
                            <div class="flex justify-center items-center">
                                <button class="bg-cyan-600 border-2 h-12 w-full">Register</button>
                            </div>
                            <p class="text-center">Already have an account? <a href="#" onclick="showLogin()">Login</a></p>
                        </form>

                    </div>

                </div>

            </div>
            
        </div>

    </section>
<script>
    function showLogin() {
        const img = document.getElementById('imageslider');

        img.classList.remove('translate-x-0');
        img.classList.add('translate-x-full');

        img.classList.remove('rounded-tr-4xl', 'rounded-br-4xl');
        img.classList.add('rounded-tl-4xl', 'rounded-bl-4xl');
    }

    function showRegister() {
        const img = document.getElementById('imageslider');

        img.classList.remove('translate-x-full');
        img.classList.add('translate-x-0');

        img.classList.remove('rounded-tl-4xl', 'rounded-bl-4xl');
        img.classList.add('rounded-tr-4xl', 'rounded-br-4xl');
    }
</script>
</body>
</html>
