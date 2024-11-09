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
                         auth()->user()->can('rack.read') ||
                         auth()->user()->can('warehouse.read'))
                     <li class="menu-title">Master</li>
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
                 <li class="menu-title">Report</li>
                 @can('read log activities management')
                     @include('layouts.admin.components.side-link', [
                         'icon' => 'mdi mdi-history',
                         'label' => 'Log Activity',
                         'route' => 'admin.log-activities', // String biasa
                     ])
                 @endcan
             </ul>
         </div>
     </div>
     <!-- Sidenav Menu End  -->
