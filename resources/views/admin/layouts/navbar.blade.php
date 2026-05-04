<div id="sidebar" class="sidebar p-3 hide">

    <div class="mb-4">
        <h5 class="text-white">
            TalentBloom
        </h5>
    </div>

    <!-- MENU -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.students.*') ? 'active' : '' }}"
            href="{{ route('admin.students.index') }}">
                <i class="bi bi-people me-2"></i>
                Manage Students
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}"
            href="{{ route('admin.teachers.index') }}">
                <i class="bi bi-person-badge me-2"></i>
                Manage Teachers
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.talents.*') ? 'active' : '' }}"
            href="{{ route('admin.talents.index') }}">
                <i class="bi bi-stars me-2"></i>
                Manage Talents
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.settings') ? 'active' : '' }}"
            href="{{ route('admin.settings') }}">
                <i class="bi bi-gear me-2"></i>
                Settings
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}"
            href="{{ route('admin.profile.edit') }}">
                <i class="bi bi-person-circle me-2"></i>
                My Profile
            </a>
        </li>

    </ul>

</div>