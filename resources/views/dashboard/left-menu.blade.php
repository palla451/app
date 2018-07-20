<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li{{ request()->segment(2) == '' ? ' class=active': '' }}>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>{{ __('Dashboard') }}</span>
                </a>
            </li>
            @permission('*-booking')
            <li{{ request()->segment(2) == 'bookings' ? ' class=active': '' }}>
                <a href="{{ route('bookings.index') }}">
                    <i class="fa fa-calendar-check-o"></i> <span>{{ __('Booking Management') }}</span>
                </a>
            </li>
            @endpermission
            @ability('superadmin|admin', '*-user')
            <li{{ request()->segment(2) == 'rooms' ? ' class=active': '' }}>
                <a href="{{ route('rooms.index') }}">
                    <i class="fa fa-briefcase"></i> <span>{{ __('Room Management') }}</span>
                </a>
            </li>
            @endability
            @ability('superadmin|admin', '*-user')
            <li{{ request()->segment(2) == 'add_optional' ? ' class=active': '' }}>
                <a href="{{ route('bookingoptionals.create') }}">
                    <i class="fa fa-plus-square"></i> <span>{{ __('Add New Optional') }}</span>
                </a>
            </li>
            @endability

            @ability('superadmin|admin', '*-user')
            <li{{ request()->segment(2) == 'booking_calendar' ? ' class=active': '' }}>
                <a href="{{ route('total_calendar_booking') }}">
                    <i class="fa fa-calendar" aria-hidden="true"></i> <span>{{ __('Booking Calendar') }}</span>
                </a>
            </li>
            @endability

            @ability('superadmin|admin', '*-user')
            <li{{ request()->segment(2) == 'booking_calendar' ? ' class=active': '' }}>
                <a href="{{ route('total_calendar_booking_eur') }}">
                    <i class="fa fa-calendar" aria-hidden="true"></i> <span>{{ __('Booking Calendar Eur') }}</span>
                </a>
            </li>
            @endability

            @ability('superadmin|admin', '*-user')
            <li{{ request()->segment(2) == 'booking_calendar' ? ' class=active': '' }}>
                <a href="{{ route('total_calendar_booking_boezio') }}">
                    <i class="fa fa-calendar" aria-hidden="true"></i> <span>{{ __('Booking Calendar Boezio') }}</span>
                </a>
            </li>
            @endability

            @ability('superadmin|admin', '*-user')
            <li{{ request()->segment(2) == 'booking_calendar' ? ' class=active': '' }}>
                <a href="{{ route('total_calendar_booking_regolo') }}">
                    <i class="fa fa-calendar" aria-hidden="true"></i> <span>{{ __('Booking Calendar Regolo') }}</span>
                </a>
            </li>
            @endability

            @ability('superadmin', '*-security')
            <li{{ request()->segment(2) == 'users' ? ' class=active': '' }}>
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-users"></i> <span>{{ __('User Management') }}</span>
                </a>
            </li>
            @endability
            @ability('superadmin', '*-security')
            <li{{ request()->segment(2) == 'security' ? ' class=active': '' }}>
                <a href="{{ route('security.index') }}">
                    <i class="fa fa-lock"></i> <span>{{ __('Security') }}</span>
                </a>
            </li>
            @endability
            <li class="header">{{ __('User Settings') }}</li>
            <!--<li>
                <a href="#"><i class="fa fa-gears text-yellow"></i> <span>{{ __('Site Settings') }}</span></a>
            </li> -->
            <li{{ request()->segment(2) == 'change-password' ? ' class=active': '' }}>
                <a href="{!! route('change-password.show') !!}">
                    <i class="fa fa-lock text-red"></i> <span>{{ __('Change Password') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out text-aqua"></i> <span>{{ __('Logout') }}</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>