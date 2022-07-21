<div class="main-wrapper">
     <!-- Sidebar -->
     <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div class="sidebar-menu">
                <ul>
                <li class="{{ Request::is('index') ? 'active' : '' }}">
<a  href="{{ url('index') }}"><i class="la la-home"></i> <span>Back to Home</span>  </a></li>

                    
                    <li class="menu-title">Settings</li>

                    <li class="{{ Request::is('institutesForm') ? 'active' : '' }}">
                        <a  href="{{ url('institutesForm') }}"><i class="la la-building"></i><span>Educational Institutes</span>  </a>
                    </li>
                    <li class="{{ Request::is('salarySettings') ? 'active' : '' }}">
                        <a  href="{{ url('salarySettings') }}"><i class="la la-money"></i> <span>Salary Settings</span>  </a>
                    </li>

                    {{-- <li class="{{ Request::is('settings') ? 'active' : '' }}">
<a  href="{{ url('settings') }}"><i class="la la-building"></i><span>Company Settings</span>  </a></li>

<li class="{{ Request::is('localization') ? 'active' : '' }}">
<a  href="{{ url('localization') }}"><i class="la la-clock-o"></i><span>Localization</span>  </a></li>

<li class="{{ Request::is('theme-settings') ? 'active' : '' }}">
<a  href="{{ url('theme-settings') }}"><i class="la la-photo"></i><span>Theme Settings</span>  </a></li>
<li class="{{ Request::is('roles-permissions') ? 'active' : '' }}">
<a  href="{{ url('roles-permissions') }}"><i class="la la-key"></i> <span>Roles & Permissions</span>  </a></li>
<li class="{{ Request::is('email-settings') ? 'active' : '' }}">
<a  href="{{ url('email-settings') }}"><i class="la la-at"></i><span>Email Settings</span>  </a></li>
<li class="{{ Request::is('invoice-settings') ? 'active' : '' }}">
<a  href="{{ url('invoice-settings') }}"><i class="la la-pencil-square"></i><span>Invoice Settings</span>  </a></li>
<li class="{{ Request::is('salary-settings') ? 'active' : '' }}">
<a  href="{{ url('salary-settings') }}"><i class="la la-money"></i> <span>Salary Settings</span>  </a></li>
<li class="{{ Request::is('notifications-settings') ? 'active' : '' }}">
<a  href="{{ url('notifications-settings') }}"><i class="la la-globe"></i><span>Notifications</span>  </a></li>
<li class="{{ Request::is('change-password') ? 'active' : '' }}">
<a  href="{{ url('change-password') }}"><i class="la la-lock"></i><span>Change Password</span>  </a></li>
<li class="{{ Request::is('leave-type') ? 'active' : '' }}">
<a  href="{{ url('leave-type') }}"><i class="la la-cogs"></i> <span>Leave Type </span>  </a></li>	 --}}
                </ul>
            </div>
        </div>
    </div>
    <!-- Sidebar -->
            </div>


			