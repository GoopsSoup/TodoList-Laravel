<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/regis.js'])
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    body { font-family: 'DM Sans', sans-serif; }
    .font-display { font-family: 'Syne', sans-serif; }
</style>
<body class="flex min-h-screen min-w-screen flex-wrap">
    <section class="w-6/12">
        <img src="/images/tasks.jpg" class="absolute h-screen"></img>
    </section>

    <section class="flex justify-center bg-white w-6/12 rounded-tl-3xl rounded-bl-3xl z-100">
        
        <div class="flex flex-col justify-center items-end">
                <p class="flex gap-2 text-[14px] tracking-wider">Already have an account? 
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 20H18C19.1046 20 20 19.1046 20 18M15 4H18C19.1046 4 20 4.89543 20 6V14M11 16L15 12H3M11 8L12 9" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                    </svg> 
                    <a href="#" class="hover:text-[blue] underline" onclick="showLogin()">Login</a> 
                </p>
            <div>
                <form action="/register" method="POST" class="flex flex-col justify-center min-w-130 md:max-w-40 min-h-160 gap-5">
                    @csrf
                    <h3 class="font-bold tracking-[1px]">Sign Up to start creating daily task !</h3>
                    <div>
                        <p class="text-[15px]">Name</p>

                        <input name="name" id="username" type="text" placeholder="Username" class="min-h-12 border-[#4c4cb68a] border-1 focus:border-[#00a6ff] focus:outline-none max-h-10 pl-3 w-full rounded-[5px] ">
                        
                        <p id="username-status" class="text-[13px] opacity-70 pl-2"></p>
                    </div>

                    <div>
                        <p class="text-[15px]">Email</p>

                        <input id="email" name="email" type="text" placeholder="user@gmail.com" class="min-h-12 border-[#4c4cb68a] border-1 focus:border-[#00a6ff] focus:outline-none max-h-10 pl-3 w-full rounded-[5px]">
                        
                        <p id="email-status" class="text-[13px] opacity-70 pl-2"></p>
                    </div>
                    
                    <div>
                        <p class="text-[15px]">Password</p> 
                        <input id="password" name="password" type="password" class="min-h-12 border-[#4c4cb68a] border-1 focus:border-[#00a6ff] focus:outline-none max-h-10 w-full pl-3 rounded-[5px]">
                        <p id="password-status" class="text-[13px] opacity-70 pl-2"></p>
                    </div>

                    <div class="flex gap-2">
                        <input type="checkbox">
                        <p class="text-[13px]">Remember me</p>
                    </div>
                    
                    
                    <div class="flex-col justify-center items-center">
                        <button class="bg-cyan-600 border-2 h-14 w-full text-[17px] rounded-[7px] font-display font-bold tracking-widest uppercase bg-[#7c6dfa] hover:bg-[#6b5ce7] disabled:opacity-35 disabled:cursor-not-allowed text-white px-5 transition-colors cursor-pointer shrink-0">Register</button>
                        <p class="text-[13px] opacity-70 pl-2">By creating an account, you agree to the Terms of Service. For more information about FlowTask privacy practices, see the FlowTask Privacy Statement. We'll occasionally send you account-related emails.</p>
                    </div>
                </form>
            </div>
        </div>
    </section>

<script>
</script>
</body>
</html>
