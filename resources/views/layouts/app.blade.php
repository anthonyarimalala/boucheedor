
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bouchée d'or - Stock </title>
    <!-- plugins:css -->

    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.5.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('star-admin2/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('star-admin2/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="" />
    <script src="{{ asset('chart.js/Chart.min.js') }}"></script>



</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
            <div class="me-3">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
            </div>
            <div>
                <a class="navbar-brand brand-logo" href="index.html">
                    <img src="{{ asset('bouchee/logo.jpg') }}" alt="logo" />
                </a>
                <a class="navbar-brand brand-logo-mini" href="index.html">
                    <img src="{{ asset('star-admin2/images/logo-mini.svg') }}" alt="logo" />
                </a>
            </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
            <ul class="navbar-nav">
                <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                    <h1 class="welcome-text"><span class="text-black fw-bold">{{ \Illuminate\Support\Facades\Auth::user()->nom }} </span></h1>
                    <h3 class="welcome-sub-text">{{ \Illuminate\Support\Facades\Auth::user()->role }} </h3>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link btn btn-sm" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout"></i> Déconnexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        <div class="theme-setting-wrapper">
            <div id="settings-trigger"><i class="ti-settings"></i></div>
            <div id="theme-settings" class="settings-panel">
                <i class="settings-close ti-close"></i>
                <p class="settings-heading">SIDEBAR SKINS</p>
                <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border me-3"></div>Light</div>
                <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border me-3"></div>Dark</div>
                <p class="settings-heading mt-2">HEADER SKINS</p>
                <div class="color-tiles mx-0 px-4">
                    <div class="tiles success"></div>
                    <div class="tiles warning"></div>
                    <div class="tiles danger"></div>
                    <div class="tiles info"></div>
                    <div class="tiles dark"></div>
                    <div class="tiles default"></div>
                </div>
            </div>
        </div>
        <div id="right-sidebar" class="settings-panel">
            <i class="settings-close ti-close"></i>
            <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                </li>
            </ul>
            <div class="tab-content" id="setting-content">
                <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                    <div class="add-items d-flex px-3 mb-0">
                        <form class="form w-100">
                            <div class="form-group d-flex">
                                <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                            </div>
                        </form>
                    </div>
                    <div class="list-wrapper px-3">
                        <ul class="d-flex flex-column-reverse todo-list">
                            <li>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox">
                                        Team review meeting at 3.00 PM
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox">
                                        Prepare for presentation
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox">
                                        Resolve all the low priority tickets due today
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li class="completed">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox" checked>
                                        Schedule meeting for next week
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li class="completed">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox" checked>
                                        Project review
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                        </ul>
                    </div>
                    <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
                    <div class="events pt-4 px-3">
                        <div class="wrapper d-flex mb-2">
                            <i class="ti-control-record text-primary me-2"></i>
                            <span>Feb 11 2018</span>
                        </div>
                        <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
                        <p class="text-gray mb-0">The total number of sessions</p>
                    </div>
                    <div class="events pt-4 px-3">
                        <div class="wrapper d-flex mb-2">
                            <i class="ti-control-record text-primary me-2"></i>
                            <span>Feb 7 2018</span>
                        </div>
                        <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
                        <p class="text-gray mb-0 ">Call Sarah Graves</p>
                    </div>
                </div>
                <!-- To do section tab ends -->
                <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
                    <div class="d-flex align-items-center justify-content-between border-bottom">
                        <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
                        <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See All</small>
                    </div>
                    <ul class="chat-list">
                        <li class="list active">
                            <div class="profile"><img src="{{ asset('star-admin2/images/faces/face1.jpg') }}" alt="image"><span class="online"></span></div>
                            <div class="info">
                                <p>Thomas Douglas</p>
                                <p>Available</p>
                            </div>
                            <small class="text-muted my-auto">19 min</small>
                        </li>
                        <li class="list">
                            <div class="profile"><img src="{{ asset('star-admin2/images/faces/face2.jpg') }}" alt="image"><span class="offline"></span></div>
                            <div class="info">
                                <div class="wrapper d-flex">
                                    <p>Catherine</p>
                                </div>
                                <p>Away</p>
                            </div>
                            <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                            <small class="text-muted my-auto">23 min</small>
                        </li>
                        <li class="list">
                            <div class="profile"><img src="{{ asset('star-admin2/images/faces/face3.jpg') }}" alt="image"><span class="online"></span></div>
                            <div class="info">
                                <p>Daniel Russell</p>
                                <p>Available</p>
                            </div>
                            <small class="text-muted my-auto">14 min</small>
                        </li>
                        <li class="list">
                            <div class="profile"><img src="{{ asset('star-admin2/images/faces/face4.jpg') }}" alt="image"><span class="offline"></span></div>
                            <div class="info">
                                <p>James Richardson</p>
                                <p>Away</p>
                            </div>
                            <small class="text-muted my-auto">2 min</small>
                        </li>
                        <li class="list">
                            <div class="profile"><img src="{{ asset('star-admin2/images/faces/face5.jpg') }}" alt="image"><span class="online"></span></div>
                            <div class="info">
                                <p>Madeline Kennedy</p>
                                <p>Available</p>
                            </div>
                            <small class="text-muted my-auto">5 min</small>
                        </li>
                        <li class="list">
                            <div class="profile"><img src="{{ asset('star-admin2/images/faces/face6.jpg') }}" alt="image"><span class="online"></span></div>
                            <div class="info">
                                <p>Sarah Graves</p>
                                <p>Available</p>
                            </div>
                            <small class="text-muted my-auto">47 min</small>
                        </li>
                    </ul>
                </div>
                <!-- chat tab ends -->
            </div>
        </div>
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">


                @if(\Illuminate\Support\Facades\Auth::user()->role == 'cuisinier' )

                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{asset('/')}}">
                        <i class="mdi mdi-view-dashboard menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{asset('actualiser-notification')}}">
                        <i class="mdi mdi-refresh menu-icon"></i>
                        <span class="menu-title">Actualiser</span>
                    </a>
                </li>
                @if(\Illuminate\Support\Facades\Auth::user()->role == 'cuisinier' )
                    <li class="nav-item nav-category">Check</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{asset('cuisine-confirmation')}}">
                            <i class="mdi mdi-check-box-multiple-outline menu-icon"></i>
                            <span class="menu-title">Confirmation de sorties</span>
                        </a>
                    </li>

                    <li class="nav-item nav-category">Cuisine</li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{asset('cuisine-ingredient')}}">
                            <i class="mdi mdi-carrot menu-icon"></i>
                            <span class="menu-title">Ingredient</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{asset('/')}}">
                            <i class="mdi mdi-silverware-fork-knife menu-icon"></i>
                            <span class="menu-title">Produit</span>
                        </a>
                    </li>

                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin' )
                    <li class="nav-item nav-category">Mouvements</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#entree" aria-expanded="false" aria-controls="ui-basic">
                            <i class="menu-icon mdi mdi-cart-arrow-down"></i>
                            <span class="menu-title">Entrée</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="entree">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('entree-produit') }}">Produit à vendre</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('entree-ingredient') }}">Ingrédient</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('entree-non-consommable') }}">Non Consommable</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sortie" aria-expanded="false" aria-controls="ui-basic">
                            <i class="menu-icon mdi mdi-cart-arrow-up"></i>
                            <span class="menu-title">Sortie</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="sortie">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('sortie-produit') }}">Produit à vendre</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('sortie-ingredient') }}">Ingrédient</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('sortie-non-consommable') }}">Non Consommable</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item nav-category">Rapport</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#stock" aria-expanded="false" aria-controls="ui-basic">
                            <i class="menu-icon mdi mdi-eye"></i>
                            <span class="menu-title">Rapport de stock</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="stock">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('inventaire-tous') }}">Tous</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('inventaire-produit') }}">Produits à vendre</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('inventaire-ingredient') }}">Ingrédients</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('inventaire-non-consommable') }}">Non Consommable</a></li>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#liste" aria-expanded="false" aria-controls="ui-basic">
                            <i class="menu-icon mdi mdi-view-list"></i>
                            <span class="menu-title">Liste et Modification</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="liste">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('liste-produits') }}">Produits</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('modifier-recette/liste-produit-transforme') }}">Fiche produit</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{asset('liste-emplacements')}}">Emplacements</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('liste-categories') }}">Catégories</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{asset('couts')}}">
                            <i class="mdi mdi-cash-marker menu-icon"></i>
                            <span class="menu-title">Valeur de stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('historique-mouvements') }}">
                            <i class="mdi mdi-history menu-icon"></i>
                            <span class="menu-title">Historique</span>
                        </a>
                    </li>


                @endif

                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                    <li class="nav-item nav-category">Ajouts</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{asset('imports')}}">
                                <i class="mdi mdi-database-import menu-icon"></i>
                                <span class="menu-title">Importer</span>
                            </a>
                        </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#insertion" aria-expanded="false" aria-controls="insertion">
                            <i class="menu-icon mdi mdi-plus"></i>
                            <span class="menu-title">Nouveau</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="insertion">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('create-produit') }}">Produit à vendre</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('create-ingredient') }}">Ingrédient</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('create-non-consommable') }}">Non Consommable</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('create-categorie') }}">Catégorie</a></li>
                                <li class="nav-item"> <a class="nav-link" href="{{ asset('create-emplacement') }}">Emplacement</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="home-tab">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a href="" target="_blank">Bootstrap admin template</a> from BootstrapDash.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{ asset('star-admin2/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('star-admin2/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('star-admin2/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('star-admin2/vendors/progressbar.js/progressbar.min.js') }}"></script>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('star-admin2/js/off-canvas.js') }}"></script>
<script src="{{ asset('star-admin2/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('star-admin2/js/template.js') }}"></script>
<script src="{{ asset('star-admin2/js/settings.js') }}"></script>
<script src="{{ asset('star-admin2/js/todolist.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('star-admin2/js/jquery.cookie.js') }}" type="text/javascript"></script>
<script src="{{ asset('star-admin2/js/dashboard.js') }}"></script>
<script src="{{ asset('star-admin2/js/Chart.roundedBarCharts.js') }}"></script>


<!-- End custom js for this page-->
</body>

</html>
