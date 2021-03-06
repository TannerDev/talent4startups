<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ route('home') }}"><img id="navbar-logo" src="{{ asset('images/t4s-identity.png') }}" alt=""/></a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li @if (Request::path() === '/') class="active" @endif><a href="{{ route('home') }}"><i class="glyphicons glyphicons-home"></i> Home</a></li>
				<li @if (Request::path() === 'talents') class="active" @endif><a href="{{ route('talents.index') }}"><i class="glyphicons glyphicons-person"></i> Talent</a></li>
				<li @if (Request::path() === 'startups') class="active" @endif><a href="{{ route('startups.index') }}"><i class="glyphicons glyphicons-lightbulb"></i> Startups</a></li>
				<li @if (Request::path() === 'about') class="active" @endif><a href="/about"><i class="glyphicons glyphicons-asterisk"></i> About</a></li>
				<li @if (Request::path() === 'manifesto') class="active" @endif><a href="/manifesto"><i class="glyphicons glyphicons-circle-question-mark"></i> Manifesto</a></li>
				<li @if (Request::path() === 'faq') class="active" @endif><a href="/faq"><i class="glyphicons glyphicons-circle-info"></i> FAQ</a></li>
				@if (Auth::user())
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						    <i class="glyphicons @if (Auth::user()->newMessagesCount() > 0)  glyphicons-user-asterisk @else glyphicons-user @endif"></i>
						    {{ Auth::user()->email }}
						    @if (Auth::user()->newMessagesCount() > 0)  <span class="btn-xs btn btn-info"><strong>{{ Auth::user()->newMessagesCount() }}</strong></span> @endif
						    <span class="caret"></span>
                        </a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{{ route('profile_path', Auth::user()->id) }}"><i class="glyphicons glyphicons-user"></i> My Profile</a></li>
							<li>
							    <a href="{{ route('messages') }}"><i class="glyphicons glyphicons-message-new"></i> Messages @if (Auth::user()->newMessagesCount() > 0)  ({{ Auth::user()->newMessagesCount() }}) @endif</a>

                            </li>
							<li><a href="/auth/logout"><span class="glyphicons glyphicons-log-out"></span> Logout</a></li>
							<li><a id="reset-link" href="/password/reset"><span class="glyphicons glyphicons-warning-sign"></span> Reset Password</a></li>
						</ul>
					</li>
				@else
					<li><a id="login-link" href="{{ route('login_path') }}"><span class="glyphicons glyphicons-log-in"></span> Login</a></li>
					<li><form><a id="signup-link" href="{{ route('register_path') }}" type="button" class="btn btn-primary navbar-btn"><span class="glyphicons glyphicons-cog"></span> Sign Up</a></form></li>
				@endif
			</ul>
		</div>
		<!--/.nav-collapse -->
	</div>
</nav>
