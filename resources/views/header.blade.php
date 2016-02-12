@section("header")
    <div class="navbar navbar-default">
        <div class="navbar-header">
          <a href="../" class="navbar-brand">Aunt Mary's Storybook Project</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">

          <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
            <li role="presentation"><a href="login">Login</a></li>
            @else
                @if (Session::has('visitID'))
                  <li role="presentation"><a href="{{ URL::to('continueVisit') }}">Active Session</a></li>
                @endif

                @if (Auth::user()->level=="admin")
                        <li role="presentation"><a href="admin">Home</a></li>
                @endif
            	<li role="presentation"><a href="http://support.storybook.cjtinc.org">Support</a></li>
           		<li role="presentation"><a href="logout">Logout</a></li>
                
            @endif
          </ul>

        </div>
    </div>

@show