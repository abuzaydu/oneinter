<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="#"><span></span></a>
        <a href="{{ asset('index.html') }}" class="b-brand">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="" class="logo images">
            <img src="{{ asset('assets/images/logo-icon.svg') }}" alt="" class="logo-thumb images">
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="#">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
    <a href="#!" class="mob-toggler"></a>
				<ul class="navbar-nav me-auto">
					<li class="nav-item">
						<!-- <div class="main-search open">
							<div class="input-group">
								<input type="text" id="m-search" class="form-control" placeholder="Search . . .">
								<a href="#!" class="input-group-append search-close">
									<i class="feather icon-x input-group-text"></i>
								</a>
								<span class="ms-1 input-group-append search-btn btn btn-primary">
									<i class="feather icon-search input-group-text"></i>
								</span>
							</div>
						</div> -->
					</li>
				</ul>
				<ul class="navbar-nav ms-auto">
					<li>
						<div class="dropdown">
							@php
								$user = auth()->user();
								$unreadNotifications = $user ? $user->unreadNotifications()->where('type', 'App\\Notifications\\NewBookingNotification')->latest()->take(5)->get() : collect();
								$unreadCount = $unreadNotifications->count();
							@endphp
							<a class="dropdown-toggle position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="icon feather icon-bell"></i>
								@if($unreadCount > 0)
									<span class="badge bg-danger position-absolute top-0 start-100 translate-middle">{{ $unreadCount }}</span>
								@endif
							</a>
							<div class="dropdown-menu dropdown-menu-end notification">
								<div class="noti-head">
									<h6 class="d-inline-block m-b-0">Notifications</h6>
									<div class="float-end">
										<form method="POST" action="{{ route('admin.notifications.markAllRead') }}">
											@csrf
											<button type="submit" class="btn btn-link btn-sm m-r-10">mark as read</button>
										</form>
									</div>
								</div>
								<ul class="noti-body">
									<li class="n-title">
										<p class="m-b-0">NEW BOOKINGS</p>
									</li>
									@forelse($unreadNotifications as $notification)
										<li class="notification">
											<div class="d-flex">
												<img class="img-radius" src="{{ $user->profile_picture_url }}" alt="Profile Image">
												<div class="flex-grow-1">
													<p><strong>{{ $notification->data['customer_name'] }}</strong>
														<span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
													</p>
													<p>New booking for {{ $notification->data['category'] ?? 'N/A' }}</p>
													<a href="{{ route('admin.bookings.show', $notification->data['booking_id']) }}" class="btn btn-sm btn-primary">View</a>
												</div>
											</div>
										</li>
									@empty
										<li><p class="text-center text-muted">No new bookings</p></li>
									@endforelse
								</ul>
								<div class="noti-footer">
									<a href="{{ route('admin.bookings.index') }}">show all</a>
								</div>
							</div>
						</div>
					</li>
					<!-- <li><a href="#!" class="displayChatbox"><i class="icon feather icon-mail"></i></a></li> -->
					<li>
						<div class="dropdown drp-user">
							@php
								$currentUser = auth()->user();
								$profileUrl = $currentUser ? $currentUser->profile_picture_url : asset('assets/images/user/avatar-1.jpg');
							@endphp
							<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
								<img src="{{ $profileUrl }}" class="img-radius" style="width: 35px; height: 35px; object-fit: cover;" alt="User-Profile-Image">
							</a>
							<div class="dropdown-menu dropdown-menu-end profile-notification">
								<div class="pro-head">
									<img src="{{ $profileUrl }}" class="img-radius"
										alt="User-Profile-Image">
									<span>
										<span class="text-muted">{{ $currentUser->roles[0]['name'] ?? 'User' }}</span>
										<span class="h6">{{ $currentUser->name }}</span>
									</span>
								</div>
								<ul class="pro-body">
									<li><a href="{{ route('profile.edit') }}" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
									<li><hr class="dropdown-divider"></li>
									<li>
										<form action="{{ route('logout') }}" method="POST" style="display: inline;">
											@csrf
											<button type="submit" class="dropdown-item" style="background: none; border: none; width: 100%; text-align: left;">
												<i class="feather icon-power text-danger"></i> Logout
											</button>
										</form>
									</li>
								</ul>
							</div>
						</div>
					</li>
				</ul>
        @php /* Copy the rest of the header content here, replacing href/src with asset() as needed */ @endphp
        <!-- ... (header content goes here, use asset() for all href/src) ... -->
    </div>
</header> 