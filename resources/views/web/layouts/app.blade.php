<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistem Peminjaman Lab Komputer Jurusan Bisnin dan Informatika</title>
    <link rel="icon" href="{{ asset('assets/img/logo poliwangi.png') }}" type="image/png">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('startbootstrap/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;700&display=swap" rel="stylesheet">


    <!-- Custom styles for this template-->
    <link href="{{ asset('startbootstrap/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('startbootstrap/css/sb-admin-2-custom.css') }}" rel="stylesheet">

     <!-- Custom styles for this page -->
     <link href="{{ asset('startbootstrap/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

     {{-- Css Select2 --}}
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-white sidebar sidebar-light accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon ">
                    <img src="{{ asset('assets/img/logo poliwangi.png') }}" alt="Logo SIJALAB" style="height: 50px; width: 50px;">
                </div>
                <div class="sidebar-brand-text mx-2 text-primary">SIJALAB</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>   

            <!-- Nav Item - Manajemen Users -->
            <li class="nav-item {{ Request::is('user') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="fas fa-users-cog"></i>
                    <span>Manajemen User</span>
                </a>
            </li>   

            <!-- Nav Item - Tahun Ajaran -->
            <li class="nav-item {{ Request::is('tahunajaran*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tahunajaran.index') }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Tahun Ajaran</span>
                </a>
            </li>  

            <!-- Nav Item - Peralatan -->
            <li class="nav-item {{ Request::is('peralatan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('peralatan.index') }}">
                    <i class="fas fa-tools"></i>
                    <span>Peralatan</span>
                </a>
            </li>  

            <!-- Nav Item - Prodi -->
            <li class="nav-item {{ Request::is('prodi*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('prodi.index') }}">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Prodi</span>
                </a>
            </li>  

            <!-- Nav Item - Kelas -->
            <li class="nav-item {{ Request::is('kelas*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kelas.index') }}">
                    <i class="fas fa-chalkboard"></i>
                    <span>Kelas</span>
                </a>
            </li>  

            <!-- Nav Item - Matakuliah -->
            <li class="nav-item {{ Request::is('matakuliah*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('matakuliah.index') }}">
                    <i class="fas fa-book-open"></i>
                    <span>Matakuliah</span>
                </a>
            </li>  

            <!-- Nav Item - Dosen -->
            <li class="nav-item {{ Request::is('dosen*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dosen.index') }}">
                    <i class="fas fa-user-tie"></i>
                    <span>Data Dosen</span>
                </a>
            </li>  

            <!-- Nav Item - Lab -->
            <li class="nav-item {{ Request::is('lab*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('lab.index') }}">
                    <i class="fas fa-network-wired"></i>
                    <span>Manajemen Lab</span>
                </a>
            </li>  

            <!-- Nav Item - Jadwal Lab -->
            <li class="nav-item {{ Request::is('jadwal_lab*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('jadwal_lab.index') }}">
                    <i class="fas fa-network-wired"></i>
                    <span>Jadwal Lab</span>
                </a>
            </li>  
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-primary topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Date -->
                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                        <div class="text-white">
                            <h4>
                                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, j F Y') }}
                            </h4>
                        </div>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ Auth::user()->profile_photo_url }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item"  href="{{ route('profile.show') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-200"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-200"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Sistem Peminjaman Lab 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-exclamation-triangle"></i> Ready to Leave?
                    </h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body text-center">
                    <i class="fas fa-sign-out-alt fa-3x text-primary mb-3"></i>
                    <p class="mb-4">Apakah Anda yakin ingin logout? Klik "Logout" untuk mengakhiri sesi Anda saat ini.</p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('startbootstrap/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('startbootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('startbootstrap/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('startbootstrap/js/sb-admin-2.min.js')}}"></script>


    <!-- Page level plugins -->
    <script src="{{ asset('startbootstrap/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('startbootstrap/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('startbootstrap/js/demo/datatables-demo.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Js Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
        $('#dataTableSemua').DataTable();
        $('#dataTableSenin').DataTable();
        $('#dataTableSelasa').DataTable();
        $('#dataTableRabu').DataTable();
        $('#dataTableKamis').DataTable();
        $('#dataTableJumat').DataTable();
    });
    </script>
    
</body>

</html>