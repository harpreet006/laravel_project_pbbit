<aside id="sidebar-left" class="sidebar-left">
				
				    <div class="sidebar-header">
				        <div class="sidebar-title">
				            Navigation
				        </div>
				        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
				            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
				        </div>
				    </div>
				
				    <div class="nano">
				        <div class="nano-content">
				            <nav id="menu" class="nav-main" role="navigation">
				            
				                <ul class="nav nav-main">
				                    <li>
				                        <a class="nav-link" href="{{url('/admin/dashboard')}}">
				                            <i class="fa fa-home" aria-hidden="true"></i>
				                            <span>Dashboard</span>
				                        </a>                        
				                    </li>

				                    <li>
				                        <a class="nav-link" href="{{url('admin/users')}}">
				                            <i class="fa fa-users" aria-hidden="true"></i>
				                            <span>Users</span>
				                        </a>
				                    </li>

				                    <li>
				                        <a class="nav-link" href="{{url('admin/courses')}}">
				                            <i class="fa fa-list-alt" aria-hidden="true"></i>
				                            <span>Courses</span>
				                        </a>
				                    </li>

				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="fa fa-list-alt" aria-hidden="true"></i>
				                            <span>Chapters</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{url('admin/chapters')}}">
				                                    All Chapters
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{url('admin/chapters/create')}}">
				                                    Add Chapter
				                                </a>
				                            </li>
				                        </ul>                  
				                    </li>



				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="fa fa-list" aria-hidden="true"></i>
				                            <span>Topics</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{url('admin/topics')}}">
				                                    All Topics
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{url('admin/topics/create')}}">
				                                    Add Topic
				                                </a>
				                            </li>
				                        </ul>                  
				                    </li>

				                    <li>
				                        <a class="nav-link" href="{{url('admin/orders')}}">
				                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
				                            <span>Orders</span>
				                        </a>
				                    </li>

				                    <li>
				                        <a class="nav-link" href="{{url('admin/notifications')}}">
				                            <i class="fa fa-bell" aria-hidden="true"></i>
				                            <span>Notifications</span>
				                        </a>                        
				                    </li>

				                     <li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="fa fa-cogs" aria-hidden="true"></i>
				                            <span>Setting</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{url('admin/gateway-listing')}}">
				                                    Payment Gateway List
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{url('admin/email-templates')}}">
				                                    Email Templates
				                                </a>
				                            </li>

				                            <li>
				                                <a class="nav-link" href="{{url('admin/logs')}}">
				                                    Site Logs
				                                </a>
				                            </li>

				                        </ul>                  
				                    </li>

				                    <li>
				                        <a class="nav-link" href="{{url('admin/coupons')}}">
				                            <i class="fa fa-ticket" aria-hidden="true"></i>
				                            <span>Coupons</span>
				                        </a>
				                    </li>

				               
				                </ul>
				            </nav>
				          
				        </div>
				
				        <script>
				            // Maintain Scroll Position
				            if (typeof localStorage !== 'undefined') {
				                if (localStorage.getItem('sidebar-left-position') !== null) {
				                    var initialPosition = localStorage.getItem('sidebar-left-position'),
				                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');
				                    
				                    sidebarLeft.scrollTop = initialPosition;
				                }
				            }
				        </script>
				        
				
				    </div>
				
				</aside>