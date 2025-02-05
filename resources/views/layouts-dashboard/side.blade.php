<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
          <div class="nav">
              <div class="sb-sidenav-menu-heading">Core</div>
              <a class="nav-link" href={{route('dashboard.index')}}>
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Dashboard
              </a>
              
              <a class="nav-link" href="{{route('transaksi.index')}}">
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Transaksi
              </a>
          </div>
      </div>
      <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          Start Bootstrap
      </div>
  </nav>
</div>