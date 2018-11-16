            <header class="header">
                <div class="logo-container">
                    <a href="/admin/dashboard" class="logo">
                        <img src="{{url('public/img/logo.png')}}" width="125" height="50" alt="Porto Admin" />
                    </a>
                    <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>
            
                <!-- start: search & user box -->
                <div class="header-right">
            
                    <form action="pages-search-results.html" class="search nav-form">
                        <div class="input-group input-search">
                            <input type="text" class="form-control" name="q" id="q" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
            
                    <span class="separator"></span>
            
                    <ul class="notifications">
                           <li>
                            <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="badge get_orders" style="display: none">0</span>
                            </a>
            
                            <div class="dropdown-menu notification-menu">
                                <div class="notification-title">
                                    <span class="float-right badge badge-default get_orders"></span>
                                    Messages
                                </div>
            
                                <div class="content">
                                    <ul id="order_notify_list">
                                    
                                    </ul>
            
                                    <hr />
            
                                    <div class="text-right">
                                        <a href="{{url('admin/orders')}}" class="view-more">View All</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                                <i class="fa fa-bell"></i>
                                <span class="badge get_notification" style="display: none">0</span>
                            </a>
            
                            <div class="dropdown-menu notification-menu">
                                <div class="notification-title">
                                    <span class="float-right badge badge-default get_notification" ></span>
                                    Alerts
                                </div>
            
                                <div class="content">
                                    <ul id="notifications_notify_list">
                                      
                                    </ul>
            
                                    <hr />
            
                                    <div class="text-right">
                                        <a href="{{url('/admin/notifications')}}" class="view-more">View All</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
            
                    <span class="separator"></span>
            
                    <div id="userbox" class="userbox">
                        <a href="#" data-toggle="dropdown">
                            <figure class="profile-picture">
                                <?php 
                                $img = $user->image ?? '!logged-user.jpg';
                                ?>
                                <img src="{{url('public/images/'.$img)}}" alt="Joseph Doe" class="rounded-circle" data-lock-picture="{{url('public/images/'.$img)}}" />
                            </figure>
                            <div class="profile-info" data-lock-name="{{$user->name}}" data-lock-email="{{$user->email}}">
                                <span class="name">{{$user->name}}</span>
                                <span class="role">{{$user->user_type}}</span>
                            </div>
            
                            <i class="fa custom-caret"></i>
                        </a>
            
                        <div class="dropdown-menu">
                            <ul class="list-unstyled mb-2">
                                <li class="divider"></li>
                                <li>
                                    <a role="menuitem" tabindex="-1" href="{{url('/admin/profile')}}"><i class="fa fa-user"></i> My Profile</a>
                                </li>
                                <!-- <li>
                                    <a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
                                </li> -->
                                <li>
                                    <a role="menuitem" tabindex="-1" href="{{url('/logout')}}"><i class="fa fa-power-off"></i> Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end: search & user box -->
            </header>
            <!-- end: header