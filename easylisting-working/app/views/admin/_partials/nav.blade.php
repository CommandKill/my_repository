<div class="panel-group main-nav" id="accordion" data-spy="affix" data-offset-top="0">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseDashboard">
          Dashboard
        </a>
      </h4>
    </div>
    <div id="collapseDashboard" class="panel-collapse collapse {{ Request::is('admin') ? 'in' : '' }}">
      <div class="panel-body">
        Welcome {{$data['user']['first_name']}} {{$data['user']['last_name']}}
        <br/><br/><a href="{{ URL::to('admin/auth/signout') }}" class="btn btn-default"><span class="glyphicon glyphicon-off"></span></a>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeller">Seller Verified</a>
      </h4>
    </div>
    <div id="collapseSeller" class="panel-collapse collapse {{ Request::is('admin/seller-verified/*') || Request::is('admin/seller-verified') ? 'in' : '' }}">
      <div class="panel-body">
        <ul>
        <li class="{{ Request::is('admin/seller-verified/waiting-for-approve') ? 'active' : '' }}"><a href="{{ URL::to('admin/seller-verified/waiting-for-approve') }}">Waiting for approval</a></li>
        <li class="{{ Request::is('admin/seller-verified/approved-list') ? 'active' : '' }}"><a href="{{ URL::to('admin/seller-verified/approved-list') }}">Approved</a></li>
        <li class="{{ Request::is('admin/seller-verified/disapproved-list') ? 'active' : '' }}"><a href="{{ URL::to('admin/seller-verified/disapproved-list') }}">Disapproved</a></li>        
      </ul>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapsePage">Car Listings</a>
      </h4>
    </div>
    <div id="collapsePage" class="panel-collapse collapse {{ Request::is('admin/post/*') || Request::is('admin/post') ? 'in' : '' }}">
      <div class="panel-body">
        <ul>
        <li class="{{ Request::is('admin/post/waiting-for-approve') ? 'active' : '' }}"><a href="{{ URL::to('admin/post/waiting-for-approve') }}">Waiting for approval</a></li>
        <li class="{{ Request::is('admin/post/report-listing') ? 'active' : '' }}"><a href="{{ URL::to('admin/post/report-listing') }}">Reported listings</a></li>
        <li class="{{ Request::is('admin/post/delete-listing') ? 'active' : '' }}"><a href="{{ URL::to('admin/post/delete-listing') }}">Deleted listings</a></li>
        <li class="{{ Request::is('admin/post') ? 'active' : '' }}"><a href="{{ URL::to('admin/post/') }}">All listings</a></li>
      </ul>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseCar">Cars</a>
      </h4>
    </div>
    <div id="collapseCar" class="panel-collapse collapse {{ Request::is('admin/car*') ? 'in' : '' }}">
      <div class="panel-body">
        <ul>
        <li class="{{ Request::is('admin/car') ? 'active' : '' }}"><a href="{{ URL::to('admin/car/') }}">All Cars</a></li>
        <li class="{{ Request::is('admin/car-vehicle') ? 'active' : '' }}"><a href="{{ URL::to('admin/car-vehicle/') }}">Car Wiki</a></li>
        <li class="{{ Request::is('admin/car-parts') ? 'active' : '' }}"><a href="{{ URL::to('admin/car-parts/') }}">Car Parts</a></li>
      </ul>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseContent">
          Contents
        </a>
      </h4>
    </div>
    <div id="collapseContent" class="panel-collapse collapse {{ Request::is('admin/content*') || Request::is('admin/page*') ? 'in' : '' }}">
      <div class="panel-body">
        <ul>
        <li class="{{ Request::is('admin/page') ? 'active' : '' }}"><a href="{{ URL::to('admin/page/') }}">Pages</a></li>
        <li class="{{ Request::is('admin/content-promote') ? 'active' : '' }}"><a href="{{ URL::to('admin/content-promote/') }}">Featured Area</a></li>
        <li class="{{ Request::is('admin/content-review') ? 'active' : '' }}"><a href="{{ URL::to('admin/content-review/') }}">Reviews</a></li>
        <li class="{{ Request::is('admin/content-blog') ? 'active' : '' }}"><a href="{{ URL::to('admin/content-blog/') }}">Blogs</a></li>
      </ul>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTool">
          Banners
        </a>
      </h4>
    </div>
    <div id="collapseTool" class="panel-collapse collapse {{ Request::is('admin/banner*') ? 'in' : '' }}">
      <div class="panel-body">
        <ul class="">
          <li class="{{ Request::is('admin/banner-page*') ? 'active' : '' }}"><a href="{{ URL::to('admin/banner-page') }}">Pages</a></li>
          <li class="{{ Request::is('admin/banner-position*') ? 'active' : '' }}"><a href="{{ URL::to('admin/banner-position') }}">Positions</a></li>
          <li class="{{ Request::is('admin/banner-file*') ? 'active' : '' }}"><a href="{{ URL::to('admin/banner-file') }}">Files</a></li>
          <li class="{{ Request::is('admin/banner/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/banner/') }}">Manage</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a href="{{ URL::to('admin/package/') }}">Listing Packages</a>
      </h4>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a href="{{ URL::to('admin/questionaire/') }}">Questionaires</a>
      </h4>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a href="{{ URL::to('admin/email-template/') }}">Email templates</a>
      </h4>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSetting">
          Settings
        </a>
      </h4>
    </div>
    <div id="collapseSetting" class="panel-collapse collapse {{ Request::is('admin/index-tool*') || Request::is('admin/api-doc*') || Request::is('admin/setting*') || Request::is('admin/system-language') || Request::is('admin/language/*') ? 'in' : '' }}">
      <div class="panel-body">
        <h5>Tools</h5>
        <ul>
        <li class="{{ Request::is('admin/api-doc') ? 'active' : '' }}"><a href="{{ URL::to('admin/api-doc') }}">All</a></li>
        <li class="{{ Request::is('admin/index-tool') ? 'active' : '' }}"><a href="{{ URL::to('admin/index-tool/') }}">Indexing Tools</a></li>
        <li><a href="{{ URL::to('admin/flush') }}">Flush</a></li>
        </ul>
        <h5>Languages</h5>
        <ul class="">
          <li class="{{ Request::is('admin/system-language') ? 'active' : '' }}"><a href="{{ URL::to('admin/system-language/') }}">System Languages</a></li>
          <li class="{{ Request::is('admin/language/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/language/en/all') }}">Languages</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapsePeople">
          People
        </a>
      </h4>
    </div>
    <div id="collapsePeople" class="panel-collapse collapse {{ Request::is('admin/subscriber*') || Request::is('admin/usergroup*') || Request::is('admin/users*') || Request::is('admin/member*') ? 'in' : '' }}">
      <div class="panel-body">
        <ul>
          <li><a href="{{ URL::to('admin/usergroup/') }}">User groups</a></li>
          <li><a href="{{ URL::to('admin/users/') }}">Users</a></li>
          <li><a href="{{ URL::to('admin/member/') }}">Members</a></li>
          <!-- <li><a href="#">Dealer</a></li> -->
          <li><a href="{{ URL::to('admin/subscriber/') }}">Site subscribers</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseStat">
          Stats
        </a>
      </h4>
    </div>
    <div id="collapseStat" class="panel-collapse collapse {{ Request::is('admin/stats*') ? 'in' : '' }}">
      <div class="panel-body">
        <ul>
          <li><a href="{{ URL::to('admin/stats/unapproved-listing') }}">Unapproved listing</a></li>
          <li><a href="{{ URL::to('admin/stats/average-time-waiting-approved') }}">Average time waiting approved</a></li>
          <li><a href="{{ URL::to('admin/stats/latest-visits') }}">Latest visits</a></li>
          <li><a href="{{ URL::to('admin/stats/latest-search-keywords') }}">10 latest search keywords or string</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
  