 <!-- Topbar Start -->
 <header class="app-header">
     <div class="flex items-center px-6 gap-3">
         <!-- Brand Logo -->
         <a href="/" class="logo-box">
             <!-- Light Brand Logo -->
             <div class="logo-light">
                 <img src="{{ asset('logo-white.png') }}" class="logo-lg" alt="Dark logo">
                 <img src="{{ asset('logo-white.png') }}" class="logo-sm" alt="Small logo">
             </div>

             <!-- Dark Brand Logo -->
             <div class="logo-dark">
                 <img src="{{ asset('logo-blue.png') }}" class="logo-lg" alt="Light logo">
                 <img src="{{ asset('logo-blue.png') }}" class="logo-sm" alt="Small logo">
             </div>
         </a>
         @persist('navbar-toggle')
             <!-- Sidenav Menu Toggle Button -->
             <button id="button-toggle-menu" class="nav-link p-2">
                 <span class="sr-only">Menu Toggle Button</span>
                 <span class="flex items-center justify-center h-6 w-6">
                     <i data-lucide="menu" class="w-6 h-6 text-xl"></i>
                 </span>
             </button>
         @endpersist

         <!-- Page Title -->
         <div class="me-auto">
             <div class="md:flex hidden">
                 <h4 class="page-title text-lg">
                     @isset($title)
                         {{ $title }}
                     @endisset
                 </h4>
             </div>
         </div>
       <livewire:notification-bar/>
         <!-- Profile Dropdown Button -->
         <div class="relative">
             <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button"
                 class="nav-link flex items-center">
                 <img src="{{ asset('vendor/') }}/assets/images/users/user-1.jpg" alt="user-image"
                     class="rounded-full h-8 w-8">
                 <span class="text-sm mx-2">{{ auth()->user()->name }}</span>
                 @persist('navbar-profile')
                     <i class="mdi mdi-chevron-down"></i>
                 @endpersist
             </button>
             <div
                 class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-44 z-50 transition-[margin,opacity] duration-300 bg-white shadow-lg border rounded py-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                 <h6 class="py-2 px-5">Welcome !</h6>
                 <hr class="my-2 -mx-2 border-gray-200 dark:border-gray-700">
                 @persist('navbar-logout')
                     <livewire:auth.logout />
                 @endpersist
             </div>
         </div>

     </div>
 </header>
 <!-- Topbar End -->
