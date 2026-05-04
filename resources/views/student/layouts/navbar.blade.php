<div id="sidebar" class="sidebar p-3 hide">

    <div class="mb-4">
        <h5 class="text-white">
            TalentBloom
        </h5>
    </div>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"
               href="{{ route('student.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('student.achievements') ? 'active' : '' }}"
               href="{{ route('student.achievements') }}">
                <i class="bi bi-trophy me-2"></i>
                My Achievements
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('student.ranking') ? 'active' : '' }}"
               href="{{ route('student.ranking') }}">
                <i class="bi bi-bar-chart-line me-2"></i>
                My Ranking
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('student.profile') ? 'active' : '' }}"
               href="{{ route('student.profile') }}">
                <i class="bi bi-person-circle me-2"></i>
                My Profile
            </a>
        </li>

    </ul>

</div>