<?php
/**
 * @var \App\View\AppView $this
 */
$this->disableAutoLayout(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal | JTK Admin</title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --jtk-navy: #003366;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #f0f2f5;
        }

        /* BACKGROUND SETUP */
        .bg-image {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            /* Uses the same background image logic */
            background-image: url('<?= $this->Url->image("adminbg.jpeg") ?>'); 
            background-size: cover;
            background-position: center;
            filter: blur(3px); /* Slight blur for focus on card */
            z-index: -1;
            transform: scale(1.02); /* Prevents blur edges */
        }
        
        .bg-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.1); /* Light overlay */
            backdrop-filter: blur(2px);
            z-index: -1;
        }

        /* CARD DESIGN - Matches Complainant Login */
        .login-card {
            background: white;
            padding: 40px 40px;
            width: 90%;
            max-width: 420px;
            border-radius: 20px; /* Rounder corners like the screenshot */
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            text-align: center;
            position: relative;
        }

        /* LOGO & BADGE */
        .logo-img {
            height: 75px;
            margin-bottom: 15px;
            width: auto;
        }

        .badge-pill {
            display: inline-block;
            background-color: #eff6ff;
            color: var(--jtk-navy);
            font-size: 10px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        /* TYPOGRAPHY */
        h1 {
            color: var(--text-main);
            font-size: 26px;
            font-weight: 800; /* Extra bold for main title */
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        p.subtitle {
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 30px;
            padding: 0 10px;
        }

        /* FORM STYLES */
        .form-group {
            margin-bottom: 18px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px 15px 12px 40px; /* Left padding for icon */
            border: 1.5px solid #e2e8f0;
            background-color: #fff;
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-main);
            outline: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        input:focus {
            border-color: var(--jtk-navy);
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
        }

        /* BUTTON STYLE */
button[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: var(--jtk-navy);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.1s, background 0.2s;
            margin-top: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 51, 102, 0.2);
        }

        button[type="submit"]:hover {
            background-color: #002244;
            transform: translateY(-1px);
        }

        button[type="submit"]:active {
            transform: translateY(1px);
        }

        /* SAFETY NET: Force any button inside the message to disappear */
        .message button,
        .message .close {
            display: none !important;
        }

        /* FOOTER & UTILS */
        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--jtk-navy); }

        .footer-secure {
            margin-top: 30px;
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

.login-card .message, 
    .login-card .alert {
        all: unset !important; /* Reset default styles */
        
        /* 1. FLEXBOX LAYOUT (The key to fixing alignment) */
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        
        /* 2. USER PORTAL COLORS (Red Theme) */
        background-color: #fee2e2 !important; /* Soft Red Bg */
        border: 1px solid #fecaca !important; /* Subtle Border */
        border-left: 5px solid #dc2626 !important; /* THE RED ACCENT BAR */
        color: #991b1b !important; /* Dark Red Text */
        
        /* 3. BOX SHAPE */
        width: 100% !important;
        padding: 16px !important;
        margin-bottom: 24px !important;
        border-radius: 8px !important;
        box-sizing: border-box !important;
        
        /* 4. FONT STYLING */
        font-family: 'Inter', sans-serif !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        text-align: left !important;
        line-height: 1.4 !important;
        
        position: relative !important;
        box-shadow: none !important;
        cursor: default !important;
    }

    /* 5. ADD THE ICON MANUALLY */
    .login-card .message::before,
    .login-card .alert::before {
        content: "\f057" !important; /* FontAwesome Circle-X Icon */
        font-family: "Font Awesome 6 Free" !important;
        font-weight: 900 !important;
        
        font-size: 22px !important;
        color: #dc2626 !important;
        margin-right: 15px !important;
        display: block !important;
    }

    /* 6. CLEANUP TEXT */
    /* If the text is wrapped in <p>, remove margins */
    .login-card .message p,
    .login-card .alert p {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* 7. HIDE UGLY BUTTONS */
    .login-card .message button, .login-card .message a, .login-card .message .btn-close,
    .login-card .alert button, .login-card .alert a, .login-card .alert .btn-close {
        display: none !important;
    }
    
    /* 8. HIDE SUCCESS MESSAGES (If they accidentally appear) */
    .login-card .message.hidden, .login-card .alert.d-none {
        display: none !important;
    }
    </style>
</head>
<body>

    <div class="bg-image"></div>
    <div class="bg-overlay"></div>
    
    <div class="login-card">
        <?= $this->Html->image('jatanegara.png', ['class' => 'logo-img', 'alt' => 'Jatanegara Logo']) ?>
        
        <div>
            <span class="badge-pill">Jabatan Tenaga Kerja</span>
        </div>

        <h1>Admin Portal</h1>
        <p class="subtitle">Secure access for JTK Officers & Administrators. Please verify your credentials.</p>
        
        <?= $this->Flash->render() ?>
        
        <?= $this->Form->create(null) ?>
            <div class="form-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <i class="fa-regular fa-user"></i>
                    <?= $this->Form->control('username', [
                        'label' => false, 
                        'required' => true, 
                        'placeholder' => 'Enter Username',
                        'templates' => ['inputContainer' => '{{content}}']
                    ]) ?>
                </div>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <?= $this->Form->control('password', [
                        'label' => false, 
                        'required' => true, 
                        'placeholder' => 'Enter Password',
                        'templates' => ['inputContainer' => '{{content}}']
                    ]) ?>
                </div>
            </div>
            
            <button type="submit">
                <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Access Portal
            </button>
        <?= $this->Form->end() ?>
        
        <a href="<?= $this->Url->build('/') ?>" class="back-link">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Main Website
        </a>

        <div class="footer-secure">
            <i class="fa-solid fa-lock"></i> Authorized Personnel Only
        </div>
    </div>

</body>
</html>