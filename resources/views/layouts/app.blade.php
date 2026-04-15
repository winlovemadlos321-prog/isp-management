<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GamTech ISP - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            /* background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%); */
        }
        .sidebar-item:hover {
            background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
            transform: translateX(5px);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }

        .custom-pagination [aria-current="page"] span {
            background-color: #f97316 !important;
            border-color: #f97316 !important;
        }

        .custom-pagination a:hover {
            background-color: #fed7aa !important;
            color: #9a3412 !important;
        }
    </style>
</head>
<body class="bg-gray-100">
    @yield('content')
</body>
</html>