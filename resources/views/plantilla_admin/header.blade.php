<div class="header-area header-style-three">
    <div class="container-fluid">
        <div class="header-content-wrapper">
            <div class="header-content d-flex justify-content-between align-items-center">
                <div class="header-left-content d-flex">
                    <div class="responsive-burger-menu d-block d-lg-none">
                        <span class="top-bar"></span>
                        <span class="middle-bar"></span>
                        <span class="bottom-bar"></span>
                    </div>

                    <div class="main-logo">
                        <a href="#">
                            <img src="{{ asset('logos/upea_logo.png') }}" alt="main-logo" width="70">
                        </a>
                    </div>

                    <form class="search-bar d-flex">
                        <img src="{{ asset('plantilla_admin/images/icon/search-normal.svg') }}" alt="search-normal">

                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    </form>

                    <div class="option-item for-mobile-devices d-block d-lg-none">
                        <i class="search-btn ri-search-line"></i>
                        <i class="close-btn ri-close-line"></i>

                        <div class="search-overlay search-popup">
                            <div class='search-box'>
                                <form class="search-form">
                                    <input class="search-input" name="search" placeholder="Search" type="text">

                                    <button class="search-button" type="submit">
                                        <i class="ri-search-line"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-right-content d-flex align-items-center">
                    <div class="header-right-option">
                        <a href="#" class="dropdown-item fullscreen-btn" id="fullscreen-button">
                            <img src="{{ asset('plantilla_admin/images/icon/maximize.svg') }}" alt="maximize">
                        </a>
                    </div>

                    {{-- <div class="header-right-option dropdown apps-option">
                        <button class="dropdown-item dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/images/icon/app.svg" alt="apps">
                        </button>

                        <div class="dropdown-menu">
                            <div class="dropdown-header d-flex justify-content-between align-items-center bg-linear">
                                <span class="title d-inline-block">Web Apps</span>
                                <span class="edit-btn d-inline-block">Edit</span>
                            </div>

                            <div class="dropdown-wrap" data-simplebar>
                                <div class="d-flex flex-wrap align-items-center">
                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-account.png" alt="icon-account">
                                        <span class="d-block mb-0">Account</span>
                                    </a>

                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-google.png" alt="icon-google">
                                        <span class="d-block mb-0">Search</span>
                                    </a>

                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-map.png" alt="icon-map">
                                        <span class="d-block mb-0">Maps</span>
                                    </a>

                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-youtube.png" alt="icon-youtube">
                                        <span class="d-block mb-0">YouTube</span>
                                    </a>

                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-playstore.png" alt="icon-playstore">
                                        <span class="d-block mb-0">Play</span>
                                    </a>

                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-gmail.png" alt="icon-gmail" loading="lazy">
                                        <span class="d-block mb-0">Gmail</span>
                                    </a>

                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-drive.png" alt="icon-drive" loading="lazy">
                                        <span class="d-block mb-0">Drive</span>
                                    </a>

                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-calendar.png" alt="icon-calendar" loading="lazy">
                                        <span class="d-block mb-0">Calendar</span>
                                    </a>

                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-bitbucket.png" alt="icon-bitbucket" loading="lazy">
                                        <span class="d-block mb-0">Bitbucket</span>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-github.png" alt="icon-github" loading="lazy">
                                        <span class="d-block mb-0">Github</span>
                                    </a>

                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-dribbble.png" alt="icon-dribbble" loading="lazy">
                                        <span class="d-block mb-0">Dribbble</span>
                                    </a>

                                    <a href="#" class="dropdown-item">
                                        <img src="assets/images/apps/icon-mail-chimp.png" alt="icon-mail-chimp" loading="lazy">
                                        <span class="d-block mb-0">Mailchimp</span>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown-footer">
                                <a href="#" class="dropdown-item">View All</a>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="header-right-option notification-option messenger-option dropdown">
                        <div class="dropdown-item dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="messages-btn">
                                <img src="assets/images/icon/message.svg" alt="message">
                                <span class="badge">3</span>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <div class="dropdown-header d-flex justify-content-between align-items-center bg-linear">
                                <span class="title d-inline-block">5 New Message</span>
                                <span class="mark-all-btn d-inline-block">Clear All</span>
                            </div>

                            <div class="dropdown-wrap" data-simplebar>
                                <a href="chat.html" class="dropdown-item d-flex">
                                    <div class="icon">
                                        <img src="assets/images/user/user-1.png" alt="user-1" loading="lazy">
                                    </div>

                                    <div class="content">
                                        <span class="d-block">Alex Dew</span>
                                        <p class="m-0">Lorem ipsum dolor sit, amet consectetur</p>
                                        <p class="sub-text mb-0">2 sec ago</p>
                                    </div>
                                </a>

                                <a href="chat.html" class="dropdown-item d-flex">
                                    <div class="icon">
                                        <img src="assets/images/user/user-2.png" alt="user-2" loading="lazy">
                                    </div>

                                    <div class="content">
                                        <span class="d-block">Anne Kew</span>
                                        <p class="m-0">Lorem ipsum dolor sit, amet consectetur</p>
                                        <p class="sub-text mb-0">5 sec ago</p>
                                    </div>
                                </a>

                                <a href="chat.html" class="dropdown-item d-flex">
                                    <div class="icon">
                                        <img src="assets/images/user/user-3.png" alt="user-3" loading="lazy">
                                    </div>

                                    <div class="content">
                                        <span class="d-block">Huhon Smith</span>
                                        <p class="m-0">Lorem ipsum dolor sit, amet consectetur</p>
                                        <p class="sub-text mb-0">3 min ago</p>
                                    </div>
                                </a>

                                <a href="chat.html" class="dropdown-item d-flex">
                                    <div class="icon">
                                        <img src="assets/images/user/user-4.png" alt="user-4" loading="lazy">
                                    </div>

                                    <div class="content">
                                        <span class="d-block">Yelax Spin</span>
                                        <p class="m-0">Lorem ipsum dolor sit, amet consectetur</p>
                                        <p class="sub-text mb-0">7 min ago</p>
                                    </div>
                                </a>

                                <a href="chat.html" class="dropdown-item d-flex">
                                    <div class="icon">
                                        <img src="assets/images/user/user-5.png" alt="user-5" loading="lazy">
                                    </div>

                                    <div class="content">
                                        <span class="d-block">Steven</span>
                                        <p class="m-0">Lorem ipsum dolor sit, amet consectetur</p>
                                        <p class="sub-text mb-0">1 sec ago</p>
                                    </div>
                                </a>
                            </div>

                            <div class="dropdown-footer">
                                <a href="chat.html" class="dropdown-item">View All</a>
                            </div>
                        </div>
                    </div>

                    <div class="header-right-option notification-option dropdown">
                        <div class="dropdown-item dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="notification-btn">
                                <img src="assets/images/icon/notification.svg" alt="notification">
                                <span class="badge">4</span>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <div class="dropdown-header d-flex justify-content-between align-items-center bg-linear">
                                <span class="title d-inline-block">6 New Notifications</span>
                                <span class="mark-all-btn d-inline-block">Mark all as read</span>
                            </div>

                            <div class="dropdown-wrap" data-simplebar>
                                <a href="inbox.html" class="dropdown-item d-flex align-items-center">
                                    <div class="icon">
                                        <i class='bx bx-message-rounded-dots'></i>
                                    </div>

                                    <div class="content">
                                        <span class="d-block">Just sent a new message!</span>
                                        <p class="sub-text mb-0">2 sec ago</p>
                                    </div>
                                </a>

                                <a href="inbox.html" class="dropdown-item d-flex align-items-center">
                                    <div class="icon">
                                        <i class='bx bx-user'></i>
                                    </div>

                                    <div class="content">
                                        <span class="d-block">New customer registered</span>
                                        <p class="sub-text mb-0">5 sec ago</p>
                                    </div>
                                </a>

                                <a href="inbox.html" class="dropdown-item d-flex align-items-center">
                                    <div class="icon">
                                        <i class='bx bx-layer'></i>
                                    </div>

                                    <div class="content">
                                        <span class="d-block">Apps are ready for update</span>
                                        <p class="sub-text mb-0">3 min ago</p>
                                    </div>
                                </a>

                                <a href="inbox.html" class="dropdown-item d-flex align-items-center">
                                    <div class="icon">
                                        <i class='bx bx-hourglass'></i>
                                    </div>

                                    <div class="content">
                                        <span class="d-block">Your item is shipped</span>
                                        <p class="sub-text mb-0">7 min ago</p>
                                    </div>
                                </a>

                                <a href="inbox.html" class="dropdown-item d-flex align-items-center">
                                    <div class="icon">
                                        <i class='bx bx-comment-dots'></i>
                                    </div>

                                    <div class="content">
                                        <span class="d-block">Steven commented on your post</span>
                                        <p class="sub-text mb-0">1 sec ago</p>
                                    </div>
                                </a>
                            </div>

                            <div class="dropdown-footer">
                                <a href="inbox.html" class="dropdown-item">View All</a>
                            </div>
                        </div>
                    </div> --}}

                    <div class="header-right-option dropdown profile-nav-item pt-0 pb-0">
                        <a class="dropdown-item dropdown-toggle avatar d-flex align-items-center" href="#"
                            id="navbarDropdown-4" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            @if (Auth::user()->perfil != null)
                                <img src="{{ asset('perfil/' . Auth::user()->perfil) }}" alt="avatar" loading="lazy">
                            @else
                                <img src="{{ asset('logos/upea_logo.png') }}" alt="avatar" loading="lazy">
                            @endif

                            <div class="d-none d-lg-block d-md-block">
                                <h3>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h3>
                                <span>{{ Auth::user()->unidad_carrera->nombre_completo ?? '' }}</span>
                            </div>
                        </a>

                        <div class="dropdown-menu">
                            <div class="dropdown-header d-flex flex-column align-items-center">
                                <div class="figure mb-3">
                                    @if (Auth::user()->perfil != null)
                                        <img src="{{ asset('perfil/' . Auth::user()->perfil) }}" class="rounded-circle"
                                            alt="avatar" loading="lazy">
                                    @else
                                        <img src="{{ asset('logos/upea_logo.png') }}" class="rounded-circle"
                                            alt="avatar" loading="lazy">
                                    @endif
                                </div>

                                <div class="info text-center">
                                    <span class="name">{{ Auth::user()->nombre }}
                                        {{ Auth::user()->apellido }}</span>
                                    <span class="badge bg-success role">
                                        {{ Auth::user()->role[0]->name }}
                                    </span>
                                    <p class="mb-3 email">
                                        <span class="__cf_email__"
                                            data-cfemail="117b7e797f627c787d76705179747d7d7e3f727e7c">{{ Auth::user()->unidad_carrera->nombre_completo ?? '' }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="dropdown-wrap">
                                <ul class="profile-nav p-0 pt-3">
                                    <li class="nav-item">
                                        <a href="{{ route('adm_perfil') }}" class="nav-link">
                                            <i class="ri-user-line"></i>
                                            <span>Perfil</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="dropdown-footer">
                                <ul class="profile-nav">
                                    <li class="nav-item">
                                        <a href="#" id="btn_cerrar_session" class="nav-link">
                                            <i class="ri-login-circle-line"></i>
                                            <span>Cerrar Sesión</span>
                                        </a>
                                        <form id="form_salir" method="post" action="{{ route('salir') }}">@csrf</form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
