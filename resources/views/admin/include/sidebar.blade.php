 <!-- sidebar menu -->
 <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

    <div class="menu_section">
      {{-- <h3>General</h3> --}}
      <ul class="nav side-menu">
          @if(Auth::user()->type=="Superadmin" || Auth::user()->type=="Admin")
            <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer"></i> Dashboard </a></li>
          @endif
          @if(Auth::user()->type=="Superadmin")
              <li><a><i class="fa fa-user"></i> Users <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="{{route('users.index')}}"> Admin Users </a></li>
                    <li><a href="{{route('user.index')}}"> Website Users </a></li>
                  </ul>
              </li>
          @endif
          <li><a><i class="fa fa-map-marker"></i> Places <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu" style="display: none">
                @if(Auth::user()->type=="Superadmin")
                    <li><a href="{{route('regions.index')}}"> Regions </a></li>
                    <li><a href="{{route('communities.index')}}"> Communities </a></li>
                @elseif(Auth::user()->type=="Admin")
                    <li><a href="{{route('communities.index')}}"> Communities </a></li>
                @endif
              </ul>
          </li>
          @if(Auth::user()->type=="Superadmin")
           
            <li><a><i class="fa fa-question-circle"></i> FAQs <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="{{route('faqs.index')}}"> FAQ Listing </a></li>
                  <li><a href="{{route('faq_categories.index')}}"> FAQ Categories </a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-cog"></i> Setting <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="{{route('banner_images.index')}}">Banner Images </a></li>
                  <li><a href="{{route('categories.index')}}">Menu Category </a></li>
                </ul>
            </li>
             <li><a href="{{route('advertises.index')}}"><i class="fa fa-home"></i> Advertises </a></li>
            <li><a href="{{route('press_releases.index')}}"><i class="fa fa-home"></i> Press Releases </a></li>
          @endif
          @if(Auth::user()->type=="Superadmin" || Auth::user()->type=="Admin")
            <li><a href="{{route('post.index')}}"><i class="fa fa-newspaper-o"></i> Posts </a></li>
            <li><a href="{{route('feature_business.index')}}"><i class="fa fa-industry"></i> Feature Business </a></li>
            <li><a href="{{route('classified.index')}}"><i class="fa fa-home"></i> Classifieds </a></li>
            <li><a href="{{route('event.index')}}"><i class="fa fa-tasks"></i> Events </a></li>
          @endif
          @if(Auth::user()->type=="Superadmin")
            <li><a href="{{route('pages.index')}}"><i class="fa fa-file"></i> Pages </a></li>
            <li><a href="{{route('tickets.index')}}"><i class="fa fa-ticket"></i> Tickets </a></li>
             
          @endif
              {{-- <li><a><i class="fa fa-desktop"></i> UI Elements <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="general_elements.html">General Elements</a>
                  </li>
                  <li><a href="media_gallery.html">Media Gallery</a>
                  </li>
                  <li><a href="typography.html">Typography</a>
                  </li>
                  <li><a href="icons.html">Icons</a>
                  </li>
                  <li><a href="glyphicons.html">Glyphicons</a>
                  </li>
                  <li><a href="widgets.html">Widgets</a>
                  </li>
                  <li><a href="invoice.html">Invoice</a>
                  </li>
                  <li><a href="inbox.html">Inbox</a>
                  </li>
                  <li><a href="calender.html">Calender</a>
                  </li>
                </ul>
              </li> --}}
              {{-- <li><a href="user.html"><i class="fa fa-table"></i> User </a></li>
              <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none">
                  <li><a href="chartjs.html">Chart JS</a>
                  </li>
                  <li><a href="chartjs2.html">Chart JS2</a>
                  </li>
                  <li><a href="morisjs.html">Moris JS</a>
                  </li>
                  <li><a href="echarts.html">ECharts </a>
                  </li>
                  <li><a href="other_charts.html">Other Charts </a>
                  </li>
                </ul>
              </li> --}}
        </ul>
    </div>
    {{-- <div class="menu_section">
      <h3>Live On</h3>
      <ul class="nav side-menu">
        <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu" style="display: none">
            <li><a href="e_commerce.html">E-commerce</a>
            </li>
            <li><a href="projects.html">Projects</a>
            </li>
            <li><a href="project_detail.html">Project Detail</a>
            </li>
            <li><a href="contacts.html">Contacts</a>
            </li>
            <li><a href="profile.html">Profile</a>
            </li>
          </ul>
        </li>
        <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu" style="display: none">
            <li><a href="page_404.html">404 Error</a>
            </li>
            <li><a href="page_500.html">500 Error</a>
            </li>
            <li><a href="plain_page.html">Plain Page</a>
            </li>
            <li><a href="login.html">Login Page</a>
            </li>
            <li><a href="pricing_tables.html">Pricing Tables</a>
            </li>

          </ul>
        </li>
        <li><a><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a>
        </li>
      </ul>
    </div> --}}

  </div>
  <!-- /sidebar menu -->