     <!-- Menu -->
     <div class="app-menu">

         <!-- Sidenav Brand Logo -->
         <a href="/" class="logo-box">
             <!-- Light Brand Logo -->
             <div class="logo-light">
                 <img src="{{ asset('logo-white.png') }}" class="w-14" alt="Light logo">
             </div>

             <!-- Dark Brand Logo -->
             <div class="logo-dark">
                 <img src="{{ asset('logo-blue.png') }}" class="w-14" alt="Light logo">
             </div>
         </a>
         <!--- Menu -->
         <div data-simplebar>

             <ul class="menu" data-fc-type="accordion" x-data="{ parentActive: null }">
                 <li class="menu-title">Navigation</li>
                 @include('layouts.admin.components.side-link', [
                     'icon' => 'mdi mdi-view-dashboard-outline',
                     'label' => 'Dashboard',
                     'route' => 'admin.dashboard', // String biasa
                 ])
                 @if (auth()->user()->can('read role management') ||
                         auth()->user()->can('read user management') ||
                         auth()->user()->can('read instagram account management'))
                     <li class="menu-title">Master</li>
                     @can('read instagram account management')
                         @include('layouts.admin.components.side-link', [
                             'icon' => 'mdi mdi-instagram',
                             'label' => 'Instagram Account',
                             'route' => 'admin.instagram-account-managements', // String biasa
                         ])
                     @endcan
                     @if (auth()->user()->can('read role management') || auth()->user()->can('read user management'))
                         @include('layouts.admin.components.side-link-multiple', [
                             'icon' => 'mdi mdi-account-lock-open-outline',
                             'label' => 'Master User',
                             'childrens' => [
                                 [
                                     'label' => 'User',
                                     'route' => 'admin.user-managements', // String biasa
                                     'permissions' => 'read user management',
                                 ],
                                 [
                                     'label' => 'Role',
                                     'route' => 'admin.role-managements', // String biasa
                                     'permissions' => 'read role management',
                                 ],
                             ],
                         ])
                     @endif
                 @endif
                 @can('create instagram services management')
                     <li class="menu-title">Services</li>
                     @include('layouts.admin.components.side-link-multiple', [
                         'icon' => 'mdi mdi-instagram',
                         'label' => 'Instagram Service',
                         'childrens' => [
                             [
                                 'label' => 'Like',
                                 'route' => 'admin.services.instagrams.like', // String biasa
                                 'permissions' => 'create instagram services management',
                             ],
                             [
                                 'label' => 'Comment',
                                 'route' => 'admin.services.instagrams.comment', // String biasa
                                 'permissions' => 'create instagram services management',
                             ],
                             [
                                 'label' => 'Follow',
                                 'route' => 'admin.services.instagrams.follow', // String biasa
                                 'permissions' => 'create instagram services management',
                             ],
                         ],
                     ])
                 @endcan
                 @if (auth()->user()->can('read instagram services management') || auth()->user()->can('read log activities management'))
                     <li class="menu-title">Report</li>
                     @can('read instagram services management')
                         @include('layouts.admin.components.side-link-multiple', [
                             'icon' => 'mdi mdi-instagram',
                             'label' => 'Instagram Report',
                             'childrens' => [
                                 [
                                     'label' => 'Like',
                                     'route' => 'admin.reports.instagrams.like', // String biasa
                                     'permissions' => 'read instagram services management',
                                 ],
                                 [
                                     'label' => 'Comment',
                                     'route' => 'admin.reports.instagrams.comment', // String biasa
                                     'permissions' => 'read instagram services management',
                                 ],
                                 [
                                     'label' => 'Follow',
                                     'route' => 'admin.reports.instagrams.follow', // String biasa
                                     'permissions' => 'read instagram services management',
                                 ],
                             ],
                         ])
                     @endcan
                     @can('read log activities management')
                         @include('layouts.admin.components.side-link', [
                             'icon' => 'mdi mdi-history',
                             'label' => 'Log Activity',
                             'route' => 'admin.log-activities', // String biasa
                         ])
                     @endcan
                 @endif
             </ul>
         </div>
     </div>
     <!-- Sidenav Menu End  -->
