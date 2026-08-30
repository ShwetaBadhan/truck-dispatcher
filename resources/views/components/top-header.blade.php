 <!-- header-dashboard -->
 <div class="header-dashboard">
     <div class="wrap">
         <div class="header-left">
             <a href="index.html">
                 <img class="" id="logo_header_mobile" alt="image" src="{{ url('images/logo/logo.svg') }}"
                     data-light="{{ url('images/logo/logo.svg') }}" data-dark="{{ url('images/logo/logo-white.svg') }}">
             </a>
             <div class="button-show-hide">
                 <i class="icon-chevron-left"></i>
             </div>

         </div>
         <div class="header-grid">

             <div class="header-item button-dark-light">
                 <i class="icon-moon"></i>
             </div>


             <div class="header-item button-zoom-maximize">
                 <div class="">
                     <i class="icon-maximize"></i>
                 </div>
             </div>

             @php
                 $authUser = auth()->user();
                 $userRole = $authUser->getRoleNames()->first() ?? 'user';

                 // Role ke hisaab se readable label
                 $roleLabels = [
                     'admin' => 'Administrator',
                     'super-admin' => 'Super Admin',
                     'teacher' => 'Teacher',
                     'student' => 'Student',
                     'manager' => 'Manager',
                 ];
                 $roleLabel = $roleLabels[$userRole] ?? ucfirst($userRole);

                 // User ka initial (avatar ke liye)
                 $initials = strtoupper(substr($authUser->name, 0, 1));
             @endphp

             <div class="popup-wrap user type-header">
                 <div class="dropdown">
                     <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3"
                         data-bs-toggle="dropdown" aria-expanded="false">
                         <span class="header-user wg-user">
                             <span class="image">
                                 @if (method_exists($authUser, 'getPhotoUrlAttribute') && $authUser->photo_url)
                                     <img src="{{ $authUser->photo_url }}" alt="{{ $authUser->name }}">
                                 @else
                                     {{-- Fallback: Initial letter avatar --}}
                                     <span
                                         style="width:40px; height:40px; border-radius:50%; background:#FF5200; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:15px;">
                                         {{ $initials }}
                                     </span>
                                 @endif
                             </span>
                             <span class="text flex flex-column">
                                 <span class="name text-main-dark">{{ $authUser->name }}</span>
                                 <span class="sub text-tiny"> {{ $roleLabel }}</span>
                             </span>
                         </span>
                     </button>

                     <div class="dropdown-menu dropdown-menu-end has-content" role="region"
                         aria-label="dropdownMenuButton3">

                         {{-- Dashboard Link --}}
                         <a href="{{ route('dashboard') }}" class="user-item">
                             <div class="icon"><i class="icon-home"></i></div>
                             <div class="body-title-2">Dashboard</div>
                         </a>

                         {{-- Profile Link (role-based) --}}
                         @if ($userRole === 'student' && $authUser->student)
                             <a href="{{ route('students.index') }}" class="user-item">
                                 <div class="icon"><i class="icon-user"></i></div>
                                 <div class="body-title-2">My Profile</div>
                             </a>
                         @else
                             <a href="{{ route('users.index') }}" class="user-item">
                                 <div class="icon"><i class="icon-users"></i></div>
                                 <div class="body-title-2">Users</div>
                             </a>
                         @endif




                         <div class="divider" style="margin:5px 0; border-bottom:1px solid #eee;"></div>

                         {{-- ✅ LOGOUT FORM (proper working) --}}
                         <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                             @csrf
                             <button type="submit" class="user-item"
                                 style="width:100%; border:none; background:none; text-align:left; cursor:pointer;">
                                 <div class="icon"><i class="icon-log-out"></i></div>
                                 <div class="body-title-2" style="color:#dc3545;">Log out</div>
                             </button>
                         </form>

                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
