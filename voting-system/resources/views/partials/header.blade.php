<header>
    <div class="logo-container">
        <div class="burger" onclick="toggleSidebar()">&#9776;</div>
        <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
        <div class="web-name">Online Voting System</div>
    </div>

    <nav class="user">
        <div class="profile-dropdown">
            <img src="{{ asset('userdefault.webp') }}" alt="Profile Picture" class="profile-pic">
            <span class="username">John Doe</span>
            <div class="dropdown">
                <button class="dropbtn">▼</button>
                <div class="dropdown-content">
                    <a href="{{ route('profile') }}">View Profile</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>
