<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Roque Management System</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background: #f3f4f6;
        }

        .layout{
            display: flex;
            min-height: 100vh;
        }

        /* ================= SIDEBAR ================= */

        .sidebar{
            width: 260px;
            background: #1f2937;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header{
            padding: 25px 15px;
            border-bottom: 1px solid #374151;
            text-align: center;
        }

        .sidebar-header h2{
            font-size: 22px;
            margin-bottom: 5px;
        }

        .sidebar-header p{
            font-size: 13px;
            color: #9ca3af;
        }

        .nav{
            flex: 1;
            padding: 15px 10px;
        }

        .nav ul{
            list-style: none;
        }

        .nav li{
            margin-bottom: 5px;
        }

        .nav a{
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
            padding: 12px 15px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .nav a:hover{
            background: #374151;
        }

        .admin-title{
            padding: 15px;
            font-size: 12px;
            color: #9ca3af;
            text-transform: uppercase;
            border-top: 1px solid #374151;
            margin-top: 10px;
        }

        .sidebar-footer{
            padding: 15px;
            border-top: 1px solid #374151;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }

        /* ================= MAIN ================= */

        .main{
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar{
            background: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .topbar h1{
            font-size: 22px;
            color: #1f2937;
        }

        .btn{
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            transition: 0.2s;
        }

        .btn-logout{
            background: #ef4444;
        }

        .btn-logout:hover{
            background: #dc2626;
        }

        .btn-login{
            background: #3b82f6;
        }

        .btn-login:hover{
            background: #2563eb;
        }

        .content{
            padding: 20px;
        }

        /* ================= MOBILE ================= */

        .menu-btn{
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 100;
            background: #1f2937;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
        }

        .overlay{
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 40;
            display: none;
        }

        .overlay.active{
            display: block;
        }

        @media(max-width: 768px){

            .menu-btn{
                display: block;
            }

            .sidebar{
                position: fixed;
                left: -260px;
                top: 0;
                z-index: 50;
                transition: 0.3s;
            }

            .sidebar.active{
                left: 0;
            }

            .topbar{
                padding-left: 60px;
            }
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-box {
            background: white;
            padding: 24px;
            border-radius: 12px;
            width: 420px;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-cancel {
            padding: 8px 12px;
            border: 1px solid #ccc;
            background: white;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-delete {
            padding: 8px 12px;
            background: #DC2626;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

    <!-- Mobile Button -->
    <button class="menu-btn" onclick="toggleSidebar()">
        ☰
    </button>

    <div class="layout">

        @auth
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">

            <div class="sidebar-header">
                <h2>
                    Welcome,
                    {{ Auth::user()->role === 'admin' ? 'Admin' : 'Staff' }}
                </h2>

                <p>Barangay Roque</p>
            </div>

            <nav class="nav">
                <ul>

                    <li>
                        <a href="{{ route('Home') }}">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('certificate_details.index') }}">
                            Certificates
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('complaint_details.index') }}">
                            Complaints
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('residents.index') }}">
                            Residents
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('transaction_details.index') }}">
                            Transactions
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('violations.index') }}">
                            Violations
                        </a>
                    </li>

                    @if(Auth::user()->role === 'admin')

                        <div class="admin-title">
                            Admin Zone
                        </div>

                        <li>
                            <a href="{{ route('certificate_types.index') }}">
                                Certificate Types
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('complaint_types.index') }}">
                                Complaint Types
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('officials.index') }}">
                                Officials
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('official_titles.index') }}">
                                Official Titles
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('payment_methods.index') }}">
                                Payment Methods
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('fines.index') }}">
                                Fines
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('transaction_types.index') }}">
                                Transaction Types
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('project_details.index') }}">
                                Projects
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('project_types.index') }}">
                                Project Types
                            </a>
                        </li>

                        <hr>

                        <li>
                            <a href="{{ route('statuses.index') }}">
                                Statuses
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.index') }}">
                                Users
                            </a>
                        </li>

                    @endif

                </ul>
            </nav>

            <div class="sidebar-footer">
                Barangay Roque v1.0
            </div>

        </aside>
        @endauth

        <!-- MAIN -->
        <div class="main">

            <!-- TOPBAR -->
            <div class="topbar">

                <div></div>

                <h1>Barangay Roque</h1>

                <div>
                    @auth

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-logout">
                            Logout
                        </button>
                    </form>

                    @else

                    <a href="{{ route('login') }}" class="btn btn-login">
                            Login
                    </a>

                    @endauth
                </div>

            </div>

            <!-- CONTENT -->
            <main class="content">
                @yield('content')
            </main>

        </div>

    </div>

    <div id="deleteModal" class="modal-overlay hidden">
        <div class="modal-box">
            <h2>Confirm Delete</h2>
            <p id="deleteMessage">Are you sure?</p>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeDeleteModal()">
                    Cancel
                </button>

                <button type="button" class="btn-delete" onclick="confirmDelete()">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        let deleteForm = null;

        function openDeleteModal(event, form, name) {
            event.preventDefault(); // stop form submit

            deleteForm = form;

            document.getElementById('deleteMessage').innerText =
                `Are you sure you want to delete ${name}? This action cannot be undone.`;

            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteForm = null;
        }

        function confirmDelete() {
            if (deleteForm) {
                deleteForm.submit();
            }
        }
    </script>

    <script>

        function toggleSidebar(){
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }

        function closeSidebar(){
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        }

    </script>



</body>
</html>
