<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('macaddress.mac') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-desktop"></i>
                        <p>Mac Address</p>
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('statusap.status') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-wifi"></i>
                        <p>Status Access Point</p>
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('report.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-file"></i>
                        <p>Report Traffic</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
