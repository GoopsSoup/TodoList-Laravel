    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css', 'resources/js/regis.js'])
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Register Page</title>
        <style>
            body { 
                font-family: 'DM Sans', sans-serif; 
                background: url("/images/tasks.jpg");
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }

            .font-display { 
                font-family: 'Syne', sans-serif; 
            }

            #auth-box {
                transition: transform 0.5s ease;
            }

            .hidden-form {
                opacity: 0;
                pointer-events: none;
            }

            #regis-form, #log-form {
                transition: opacity 0.2s ease;
            }

            .active-form {
                opacity: 1;
                pointer-events: auto;
            }

            #slide-container {
                display: flex;
                width: 100%; 
                height: 100%;
            }
        </style>
    </head>

    <body class="flex min-h-screen">

        <div class="w-6/12 flex justify-center items-center bg-white flex-wrap rounded-tr-2xl rounded-br-2xl rounded-tl-2xl rounded-bl-2xl relative overflow-hidden" id="auth-box"> 

             {{-- Registers pageeeee --}}
            <section class="flex justify-center absolute active-form" id="regis-form">
                <div class="flex flex-col justify-center items-start px-6 py-10 w-full max-w-lg">
                    <p class="flex gap-2 text-[14px] tracking-wider mb-2">Already have an account?
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 20H18C19.1046 20 20 19.1046 20 18M15 4H18C19.1046 4 20 4.89543 20 6V14M11 16L15 12H3M11 8L12 9" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <a href="#" class="hover:text-blue-600 underline" onclick="showLogin(event)">Log in</a>
                    </p>
                    <form action="/register" method="POST" class="flex flex-col w-full gap-5 pt-4">
                        @csrf
                        <h3 class="font-bold tracking-[1px] text-xl">Sign Up to start creating daily task !</h3>
                        <div>
                            <p class="text-[15px]">Name</p>
                            <input name="name" id="username" type="text" placeholder="Username" oninput="this.value = this.value.replace(/\s/g, '')"    
                                class="min-h-12 border-[#4c4cb68a] border focus:border-[#00a6ff] focus:outline-none max-h-10 pl-3 w-full rounded-[5px]">
                            <p id="username-status" class="text-[13px] opacity-70 pl-2"></p>
                            </div>

                        <div>
                            <p class="text-[15px]">Email</p>
                            <input id="email" name="email" type="text" placeholder="user@gmail.com" oninput="this.value = this.value.replace(/\s/g, '')"
                                class="min-h-12 border-[#4c4cb68a] border focus:border-[#00a6ff] focus:outline-none max-h-10 pl-3 w-full rounded-[5px]">
                            <p id="email-status" class="text-[13px] opacity-70 pl-2"></p>
                        </div>

                        <div>
                            <p class="text-[15px]">Password</p>
                            <input id="password" name="password" type="password" oninput="this.value = this.value.replace(/\s/g, '')"
                                class="min-h-12 border-[#4c4cb68a] border focus:border-[#00a6ff] focus:outline-none max-h-10 w-full pl-3 rounded-[5px]">
                            <p id="password-status" class="text-[13px] opacity-70 pl-2"></p>
                        </div>

                        <div class="flex flex-col gap-2">
                            <button class="border-2 h-14 w-full text-[17px] rounded-[7px] font-display font-bold tracking-widest uppercase bg-[#7c6dfa] hover:bg-[#6b5ce7] disabled:opacity-35 disabled:cursor-not-allowed text-white px-5 transition-colors cursor-pointer shrink-0">
                                Register
                            </button>
                            <p class="text-[13px] opacity-70 pl-2">By creating an account, you agree to the Terms of Service. For more information about FlowTask privacy practices, see the FlowTask Privacy Statement. We'll occasionally send you account-related emails.</p>
                        </div>
                    </form>
                </div>
            </section>

            {{-- Login pagee --}}
            <section class="flex justify-center bg-white w-full opacity-0 hidden-form" id="log-form">
                <div class="flex flex-col justify-center items-start px-6 py-10 w-full max-w-lg">
                    <p class="flex gap-2 text-[14px] tracking-wider mb-2">Don't have an account?
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 4H6C4.89543 4 4 4.89543 4 6V18C4 19.1046 4.89543 20 6 20H9M13 8L9 12H21M13 16L12 15" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <a href="#" class="hover:text-blue-600 underline" onclick="showRegister(event)">Sign Up</a>
                    </p>
                    <form action="/login" method="POST" class="flex flex-col w-full gap-5 pt-4">
                        @csrf
                        <h3 class="font-bold tracking-[1px] text-xl">Welcome back! Log in to your account.</h3>
                        <div>
                            <p class="text-[15px]">Email</p>
                            <input name="loginEmail" id="username" type="text" placeholder="Email"
                                class="min-h-12 border-[#4c4cb68a] border focus:border-[#00a6ff] focus:outline-none max-h-10 pl-3 w-full rounded-[5px]">
                            <p id="username-status" class="text-[13px] opacity-70 pl-2"></p>
                        </div>                            
                        <div>
                            <p class="text-[15px]">Password</p>
                            <input name="loginPassword" type="password"
                                class="min-h-12 border-[#4c4cb68a] border focus:border-[#00a6ff] focus:outline-none max-h-10 w-full pl-3 rounded-[5px]">
                        </div>
                        <div>
                            <button class="border-2 h-14 w-full text-[17px] rounded-[7px] font-display font-bold tracking-widest uppercase bg-[#7c6dfa] hover:bg-[#6b5ce7] disabled:opacity-35 disabled:cursor-not-allowed text-white px-5 transition-colors cursor-pointer shrink-0">
                                Log In
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </body>
<script>
    function showLogin(e) {
        e.preventDefault();

        const box = document.getElementById("auth-box");
        const formReg = document.getElementById("regis-form");
        const formLog = document.getElementById("log-form");

        box.style.transform = "translateX(100%)";

        formReg.classList.remove("active-form");
        formReg.classList.add("hidden-form");

        formLog.classList.remove("hidden-form");
        formLog.classList.add("active-form");
    }

    function showRegister(e) {
        e.preventDefault();

        const box = document.getElementById("auth-box");
        const formReg = document.getElementById("regis-form");
        const formLog = document.getElementById("log-form");

        box.style.transform = "translateX(0%)";

        formReg.classList.remove("hidden-form");
        formReg.classList.add("active-form");

        formLog.classList.remove("active-form");
        formLog.classList.add("hidden-form");
    }
</script>
</html>