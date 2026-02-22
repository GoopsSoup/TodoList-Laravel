<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body class="bg-[#f0f0f0] min-h-screen">

    <header>
            sup
    </header>

    <main class="flex min-h-screen  ">
        <aside class="w-40 bg-[#d9e3f3] sticky top-0 self-start h-">
            @auth
            <form action="/logout" method="POST">
            @csrf
                <button class="cursor-pointer">Logout</button>
            </form>
            @else
            <a href="/register">
            @csrf
                <button>Register</button>
            </a>
            @endauth        
        </aside>

        <section class="flex flex-1">  

            {{-- Lists --}}
            <div class="h-full w-full flex items-center justify-center flex-col flex-1">

                <div class="flex items-center flex-col w-12/12 p-[2%] gap-1 md:gap-2 lg:gap-3">
                    
                    {{-- Add list --}}
                    <div class="flex h-12 w-12/12 m-6">
                        <form action="/create-list" method="POST" class="flex w-full justify-between">
                            @csrf
                            <input name="list" type="text" placeholder="Add A Task"
                            {{ auth()->guest() ? 'disabled' : '' }}
                            class="h-full p-1 bg-[#e7e7ee] w-11/12 rounded-tl-[10px] rounded-bl-[4px] pl-2 shadow-[0_1px_3px_rgba(0,0,110,0.50)] list-input">
                            <button {{ auth()->guest() ? 'disabled' : '' }} 
                                class="bg-[#1efc17] rounded-br-[10px] rounded-tr-[4px] w-1/12 shadow-[0px_1px_3px_rgba(0,0,110,0.50)] z-20 save-button">
                                Save
                            </button>
                        </form>
                    </div>

                    {{-- lists --}}
                    <div 
                    class="w-full  max-h-[75vh] flex flex-col justify-start items-center gap-y-5 bg-[#f6f6f6] rounded-[5px] shadow-[inset_0_0px_15px_rgba(10,10,150,0.30)] overflow-y-auto pb-10 pt-10
                    custom-scrollbar">
                        @foreach ($posts as $post)
                            <div 
                            class="flex bg-[#faf9f9] justify-between items-center min-h-16 w-11/12 pr-[1%] pl-[1%] rounded-[4px] border border-[#d2d2d2] shadow-[0_2px_1px_rgba(20,20,200,0.40)]
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
                </div>

            
            </div>

        </section>
    </main>

    
    <footer class="w-full h-20 gap-20">
        <div class="bg-[#f0f0f0] h-full">
            
        </div>  
    </footer>
    
    
</body>
</html>