<div id="sidebar" class="sidebar p-3 hide">

    <div class="mb-4">
        <h5 class="text-white">
            TalentBloom
        </h5>
    </div>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}"
               href="{{ route('teacher.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('teacher.students.*') ? 'active' : '' }}"
               href="{{ route('teacher.students.index') }}">
                <i class="bi bi-people me-2"></i>
                Student Profile
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('teacher.talents.*') ? 'active' : '' }}"
               href="{{ route('teacher.talents.index') }}">
                <i class="bi bi-stars me-2"></i>
                Manage Talents
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('teacher.profile.*') ? 'active' : '' }}"
               href="{{ route('profile.edit') }}">
                <i class="bi bi-person-circle me-2"></i>
                My Profile
            </a>
        </li>

    </ul>

</div>