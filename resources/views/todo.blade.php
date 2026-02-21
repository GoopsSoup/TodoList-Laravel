<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body class="bg-[#f0f0f0] flex flex-col min-h-screen">
    <header class="h-20 bg-[#4f46e5] flex items-center justify-center">
        <h1 class="text-2xl">To Do List</h1>
    </header>

    <main class="flex flex-1">  

        <aside class="w-1/6 bg-[#1e293b]">
            hello
        </aside>
        {{-- Lists --}}
        <section class="h-full w-full flex items-center justify-center flex-col flex-1">

            <div class="flex items-center flex-col w-9/12 p-[2%] gap-1 md:gap-2 lg:gap-3">
                
                {{-- Add list --}}
                <div class="flex h-12 w-10/12 m-6">
                    <form action="/create-list" method="POST" class="flex w-full justify-between">
                        @csrf
                        <input name="list" type="text" placeholder="Add List Here"
                        {{ auth()->guest() ? 'disabled' : '' }}
                        class="h-full p-1 bg-[#e7e7ee] w-10/12 rounded-tl-[20px] rounded-bl-[10px] pl-2 shadow-[0_5px_1px_rgba(0,0,0,0.50)] border-r-1 border-[#808080] list-input">
                        <button {{ auth()->guest() ? 'disabled' : '' }} 
                            class="bg-[#4fee4a] rounded-br-[20px] rounded-tr-[10px] w-2/12 shadow-[0px_5px_1px_rgba(0,0,0,0.50)] border-l-1 border-[#808080] save-button">
                            Save
                        </button>
                    </form>
                </div>

                {{-- lists --}}
                    <div 
                    class="w-12/12  max-h-[65vh] flex flex-col justify-start items-center gap-y-5 bg-slate-200 rounded-2xl shadow-[inset_0_0px_15px_rgba(10,10,150,0.20)] overflow-y-auto pb-10 pt-10
                    custom-scrollbar">
                        @foreach ($posts as $post)
                            <div 
                            class="flex bg-[#faf9f9] justify-between items-center min-h-16 w-11/12 pr-[1%] pl-[1%] rounded-2xl border border-[#d2d2d2] shadow-[0_5px_1px_rgba(20,20,200,0.50)]
                            cards">

                                <div class="relative group flex-1 min-w-0">

                                    <h4 class="text-[1.2rem] p-2 truncate text-[#0f172a]">
                                        {{$post['list']}}
                                    </h4>

                                    <div class="absolute max-w-8/12 mt-1 hidden group-hover:block w-auto bg-gray-700 text-white text-sm p-2 rounded-lg z-50 break-words opacity-70">
                                        {{$post['list']}}
                                    </div>

                                </div>

                                {{-- <h4>{{$post['list']}} //by {{$post->user->name}}//</h4> --}}
                                <!--untuk melihat siapa yang upload list tersebut ^-->

                                <div class="flex justify-between w-1/12">
                                    {{-- Edit list --}}
                                    <p><a href="/edit-list/{{$post->id}}" {{ auth()->guest() ? 'disabled' : '' }}>E</a></p>
                                    {{-- Delete list --}}
                                    <form action="/delete-list/{{$post->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button {{ auth()->guest() ? 'disabled' : '' }} class="cursor-pointer">
                                            D
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @auth
                <form action="/logout" method="POST">
                    @csrf
                    <button>Logout!</button>
                </form>
                @else
                <a href="/register">
                    @csrf
                    <button>Register</button>
                </a>
                @endauth
            </div>

        
        </section>

    </main>
    
    <footer class="w-full h-20 gap-20">
        <div class="bg-[black] h-full">
            sup
        </div>  
    </footer>
    
    
</body>
</html>