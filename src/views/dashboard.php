<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>App - Gestion de stock</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom fonts for this template -->
    <link href="<?= BASE_URL ?>/assets-template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= BASE_URL ?>/assets-template/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?= BASE_URL ?>/assets-template/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon ">
                    <i class="fas fa-box"></i>
                </div>
                <div class="sidebar-brand-text mx-3"> G-Stock </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php?action=dashboard">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tableau de bord</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search 
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>-->

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

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                <?php
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                if (!empty($_SESSION['success'])) {
                    echo '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ' . htmlspecialchars($_SESSION['success']) . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    unset($_SESSION['success']);
                }

                if (!empty($_SESSION['errors'])) {
                    echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">';
                    foreach ($_SESSION['errors'] as $error) {
                        echo '<li>' . htmlspecialchars($error) . '</li>';
                    }
                    echo '</ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    unset($_SESSION['errors']);
                }
                ?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Stock Produits</h1>
                    <p class="d-inline-flex">
                        <button id="toggleMovieBtn" class="btn toggleButton toggleAdminBtn d-sm-inline-block btn btn-sm btn-primary shadow-sm" type="button" data-toggle="collapse" data-target="#formFimlCollapse" aria-expanded="false" aria-controls="formFimlCollapse">Ajouter un produit
                            <span class="toggle-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span> 
                        </button>
                    </p>

                    <section class="create-form">
                        <div class="">
                            <div class="row">
                                <div class="col">
                                    <div class="collapse multi-collapse" id="formFimlCollapse">
                                        <div class="card card-body">
                                            <form method="POST" action="index.php?action=createProduct" class="text-start" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="nom">Nom du produit</label>
                                                        <input type="text" name="nom" class="form-control" placeholder="Nom du produit" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="marque">Marque</label>
                                                        <input type="text" name="marque" class="form-control" placeholder="Marque" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="quantite">Quantité</label>
                                                        <input type="number" name="quantite" class="form-control" placeholder="Quantité" min="0" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="categorie">Catégorie</label>
                                                        <input type="text" name="categorie" class="form-control" placeholder="Catégorie" required>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <p class="mb-4">Tableau de bord de la gestion du stock</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tous les produits</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Marque</th>
                                            <th>Quantité</th>
                                            <th>Catégorie</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Marque</th>
                                            <th>Quatité</th>
                                            <th>Catégorie</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                                         
                                    <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($product['nom'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($product['marque'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($product['quantite'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($product['categorie'] ?? '') ?></td>
                                            <td>
                                                <a href="index.php?action=editProduct&id=<?= $product['_id'] ?>" class="btn btn-sm btn-primary mr-2">Mettre à jour</a>
                                                <a href="index.php?action=deleteProduct&id=<?= $product['_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');">Supprimer</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
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


    <!-- Bootstrap core JavaScript-->
    <script src="<?= BASE_URL ?>/assets-template/vendor/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>/assets-template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= BASE_URL ?>/assets-template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= BASE_URL ?>/assets-template/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= BASE_URL ?>/assets-template/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= BASE_URL ?>/assets-template/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= BASE_URL ?>/assets-template/js/demo/datatables-demo.js"></script>

</body>

</html>