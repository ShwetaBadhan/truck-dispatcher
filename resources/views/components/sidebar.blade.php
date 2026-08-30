 <!-- section-menu-left -->
 <div class="overplay-menu d-lg-none"></div>
 <div class="section-menu-left">
     <div class="box-logo">
         <a href="{{ route('dashboard') }}" id="site-logo-inner">
             <img class="" id="logo_header" alt="image"
                 src="https://www.ambedkariti.com/assets/img/logo/logo-iti.png"
                 data-light="https://www.ambedkariti.com/assets/img/logo/logo-iti.png"
                 data-dark="https://www.ambedkariti.com/assets/img/logo/logo-iti.png">
         </a>
         <div class="button-show-hide">
             <i class="icon-chevron-left"></i>
         </div>
     </div>
     <div class="section-menu-left-wrap">
         <div class="center">
             <div class="center-item">
                 <ul class="">
                 @can('view-dashboard')
                     <li class="menu-item">
                         <a href="{{ route('dashboard') }}" class="menu-item-button">
                             <div class="icon">
                                 <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd" clip-rule="evenodd"
                                         d="M12.2652 3.57566C12.1187 3.42921 11.8813 3.42921 11.7348 3.57566L5.25 10.0605V19.8748C5.25 20.0819 5.41789 20.2498 5.625 20.2498H9V16.1248C9 15.0893 9.83947 14.2498 10.875 14.2498H13.125C14.1605 14.2498 15 15.0893 15 16.1248V20.2498H18.375C18.5821 20.2498 18.75 20.0819 18.75 19.8748V10.0605L12.2652 3.57566ZM20.25 11.5605L21.2197 12.5302C21.5126 12.8231 21.9874 12.8231 22.2803 12.5302C22.5732 12.2373 22.5732 11.7624 22.2803 11.4695L13.3258 2.51499C12.5936 1.78276 11.4064 1.78276 10.6742 2.515L1.71967 11.4695C1.42678 11.7624 1.42678 12.2373 1.71967 12.5302C2.01256 12.8231 2.48744 12.8231 2.78033 12.5302L3.75 11.5605V19.8748C3.75 20.9104 4.58947 21.7498 5.625 21.7498H18.375C19.4105 21.7498 20.25 20.9104 20.25 19.8748V11.5605ZM13.5 20.2498H10.5V16.1248C10.5 15.9177 10.6679 15.7498 10.875 15.7498H13.125C13.3321 15.7498 13.5 15.9177 13.5 16.1248V20.2498Z"
                                         fill="#111111" />
                                 </svg>
                             </div>
                             <div class="text">Dashboard</div>
                         </a>

                     </li>
                 @endcan
                     @can('view-driver')
                          <li class="menu-item">
                         <a href="{{ route('drivers.index') }}" class="">
                             <div class="icon"><i class="icon-users"></i></div>
                             <div class="text">Driver</div>
                         </a>
                     </li>
                     @endcan
                    @can('view-trucks')
                         <li class="menu-item">
                         <a href="{{ route('trucks.index') }}" class="">
                             <div class="icon"><i class="icon-truck"></i></div>
                             <div class="text">Truck</div>
                         </a>
                     </li>
                    @endcan
                    @can('view-trailers')
                         <li class="menu-item">
                         <a href="{{ route('trailers.index') }}" class="">
                             <div class="icon"><i class="icon-truck"></i></div>
                             <div class="text">Trailer</div>
                         </a>
                     </li>
                    @endcan
                    @can('view-companies')
                         <li class="menu-item">
                         <a href="{{ route('companies.index') }}" class="">
                             <div class="icon"><i class="icon-home"></i></div>
                             <div class="text">Company</div>
                         </a>
                     </li>
                    @endcan
                    @can('view-dispatch')
                         <li class="menu-item">
                         <a href="{{ route('dispatches.index') }}" class="">
                             <div class="icon"><i class="icon-link"></i></div>
                             <div class="text">Dispatch</div>
                         </a>
                     </li>
                    @endcan
                    @can('view-students')
                         <li class="menu-item">
                         <a href="{{ route('students.index') }}" class="">
                             <div class="icon"><i class="icon-link"></i></div>
                             <div class="text">Students</div>
                         </a>
                     </li>
                    @endcan
                    @can('view-batches')
                         <li class="menu-item">
                         <a href="{{ route('batches.index') }}" class="">
                             <div class="icon"><i class="icon-book"></i></div>
                             <div class="text">Batches</div>
                         </a>
                     </li>
                    @endcan
                    @can('view-syllabus')
                         <li class="menu-item">
                         <a href="{{ route('syllabuses.index') }}" class="">
                             <div class="icon"><i class="icon-book"></i></div>
                             <div class="text">Syllabus</div>
                         </a>
                     </li>
                    @endcan
                    @can('view-lectures')
                         <li class="menu-item">
                         <a href="{{ route('lectures.index') }}" class="">
                             <div class="icon"><i class="icon-calendar"></i></div>
                             <div class="text">Daily Lectures</div>
                         </a>
                     </li>
                    @endcan
                    



                     @can('view-admin')
                         <li class="menu-item has-children">
                         <a href="#" class="menu-item-button">
                             <div class="icon"><i class="icon-user"></i></div>
                             <div class="text">Administration</div>
                         </a>
                         <ul class="sub-menu">
                             <li class="sub-menu-item">
                                 <a href="{{ route('users.index') }}" class="">
                                     <div class="text">All user</div>
                                 </a>
                             </li>
                             <li class="sub-menu-item">
                                 <a href="{{ route('roles.index') }}" class="">
                                     <div class="text">Roles</div>
                                 </a>
                             </li>
                             <li class="sub-menu-item">
                                 <a href="{{ route('permissions.index') }}" class="">
                                     <div class="text">Permissions</div>
                                 </a>
                             </li>
                             
                         </ul>
                     </li> 
                     @endcan
                    

                 </ul>
             </div>

         </div>

     </div>
 </div>
