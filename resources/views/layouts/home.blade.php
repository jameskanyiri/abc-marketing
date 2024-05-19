<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ABC Marketing company</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    @livewireStyles
</head>

<body class="bg-gray-200">


    <nav class="bg-white   w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('commission.report') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
               
                <p class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
                    A<span class="text-red-700">B</span>C 
                    Marketing
                </p>
            </a>
         
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul
                    class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white ">
                    <li>
                        <a href="{{ route('commission.report') }}"
                            class=" py-2 px-3 text-black  {{ request()->is('/') ? 'text-red-700 font-bold' : '' }}"
                            aria-current="page">
                            Commission Report (Task 1)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('top.distributor') }}"
                            class=" py-2 px-3 text-black  {{ request()->is('top-distributor') ? 'text-red-700 font-bold' : '' }} ">Top Distributors Report (Task 2)</a>
                    </li>
                  
                </ul>
            </div>
        </div>
    </nav>


    <div class=" px-4 mx-auto py-4 ">
        {{ $slot }}
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



    </script>
    @livewireScripts
</body>

</html>
