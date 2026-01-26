<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JTK Complaint System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Background Image with Overlay */
            background: linear-gradient(rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.4)), 
                        url('<?= $this->Url->image('jtkbg.jpg') ?>') no-repeat center center fixed;
            background-size: cover;
        }

        .landing-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 480px;
            text-align: center;
            border-top: 5px solid #003366; /* JTK Navy Top Border */
        }

        .logo-img { height: 80px; margin-bottom: 20px; }
        
        .badge-pill-blue {
            background-color: #e3f2fd;
            color: #003366;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 50px;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 15px;
        }

        .btn-primary-jtk {
            background-color: #003366;
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: 0.2s;
            margin-bottom: 15px;
        }
        .btn-primary-jtk:hover { background-color: #002244; color: white; transform: translateY(-2px); }

        .btn-outline-jtk {
            background-color: transparent;
            border: 2px solid #003366;
            color: #003366;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: 0.2s;
        }
        .btn-outline-jtk:hover { background-color: #f8f9fa; color: #002244; transform: translateY(-2px); }

        .admin-link {
            color: #6c757d;
            font-size: 0.8rem;
            text-decoration: none;
            font-weight: 600;
            margin-top: 30px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: 0.2s;
        }
        .admin-link:hover { color: #003366; }
    </style>
</head>
<body>

    <?= $this->fetch('content') ?>

</body>
</html>