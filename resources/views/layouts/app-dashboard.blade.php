
<!DOCTYPE html>
<html>
    <head>
        @include('template-dashboard.metadata')

       
        <!-- =======================================================
        * Template Name: NiceAdmin
        * Updated: Nov 17 2023 with Bootstrap v5.3.2
        * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
      </head>

  <body>
       <!-- Modal -->
       <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Log Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin Ingin Logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Pastikan action logout ditambahkan di sini -->
                    <form action="#" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
      </div>
        <!-- Navbar -->
      @include('template-dashboard.navbar')
      <!-- end Navbar -->

        <!-- sidenav  -->
        @include('template-dashboard.sidebar')
        <!-- end sidenav -->
        {{-- <!-- sidenav  -->
        @include('template-dashboard.sidebarkosong')
        <!-- end sidenav --> --}}

        <!-- row 1 -->
        @yield('content')
        
        
      <!-- end cards -->
     
      <!-- footer -->
      @include('template-dashboard.footer')
    
     <!-- plugins:js -->

     <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

     @include('template-dashboard.metascript')
 
 
  </body>  


</html>
