<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
            margin: 0;
        }
        .navbar {
            background-color: #f5f5dc; /* لون البيج */
            border-bottom: 2px solid #d3d3d3; /* خط سفلي بسيط */
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #000000;
        }
        .navbar-brand:hover, .navbar-nav .nav-link:hover {
            color: #495057; /* لون رمادي داكن عند التمرير */
        }
        .sidenav {
            width: 250px;
            background-color: #f5f5dc; /* اللون البيج */
            color: #000000; /* نص داكن */
            padding: 15px;
            height: calc(100vh - 56px); /* ارتفاع متناسق مع الـ Navbar */
            position: fixed;
            top: 56px; /* ارتفاع الـ Navbar */
            overflow-y: auto; /* إضافة تمرير عند الحاجة */
        }
        .sidenav h2 {
            font-size: 1.5rem;
            color: #000000;
            text-align: center;
            margin-bottom: 20px;
        }
        .sidenav a {
            display: flex;
            align-items: center;
            color: #000000;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-bottom: 10px;
        }
        .sidenav a:hover {
            background-color: #d3d3d3; /* لون رمادي فاتح عند التمرير */
        }
        .sidenav i {
            margin-right: 10px;
        }
        .sidenav ul {
            margin-left: 15px;
            padding-left: 0;
            list-style: none;
        }
        .sidenav ul li {
            margin-bottom: 5px;
        }
        .main {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#"><i class="fas fa-home"></i> Company Name</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-house-user"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-user-circle"></i> Profile</a>
                </li>
                <li class="nav-item">
                    <form action="#" method="POST" style="display:inline;">
                        <button type="submit" class="btn btn-link nav-link"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidenav">
        <h2>Menu</h2>

        <!-- الكتب -->
        <a href="#" onclick="toggleMenu('booksMenu')">
            <i class="fas fa-book"></i> Books
        </a>
        <ul id="booksMenu" style="display: none;">
            <li><a href="{{ route('books.index') }}"><i class="fas fa-eye"></i> View Books</a></li>
            <li><a href="#"><i class="fas fa-trash"></i> Deleted Books</a></li>
        </ul>

        <!-- المؤلفون -->
        <a href="#" onclick="toggleMenu('authorsMenu')">
            <i class="fas fa-user"></i> Authors
        </a>
        <ul id="authorsMenu" style="display: none;">
            <li><a href="{{ route('authors.index') }}"><i class="fas fa-eye"></i> View Authors</a></li>
            <a href="{{ route('authors.trashed') }}"><i class="fas fa-trash"></i> Deleted Authors</a>
        </ul>

        <!-- التصنيفات -->
        <a href="#" onclick="toggleMenu('categoriesMenu')">
            <i class="fas fa-list"></i> Categories
        </a>
        <ul id="categoriesMenu" style="display: none;">
            <li><a href="{{ route('categories.index') }}"><i class="fas fa-eye"></i> View Categories</a></li>
            <li><a href="#"><i class="fas fa-trash"></i> Deleted Categories</a></li>
        </ul>

        <!-- الطلبات -->
        <a href="#">
            <i class="fas fa-shopping-cart"></i> Orders
        </a>

        <!-- الإعدادات -->
        <a href="#">
            <i class="fas fa-cog"></i> Settings
        </a>
    </div>

    <!-- Main Section -->
    <div class="main">
        <!-- محتوى الصفحة الرئيسي -->
        @yield('content')


    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Footer Content &copy;2025</pp>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
