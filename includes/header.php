<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Editor - OTB Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo">
                <div class="logo-icon">⚔️</div>
                <span>Item Editor</span>
            </a>
            <nav class="nav-main">
                <a href="?page=editor" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'editor') ? 'active' : ''; ?>">
                    📝 Editor
                </a>
                <a href="?page=load" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'load') ? 'active' : ''; ?>">
                    📂 Load OTB
                </a>
                <a href="?page=save" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'save') ? 'active' : ''; ?>">
                    💾 Save OTB
                </a>
                <a href="?page=otb" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'otb') ? 'active' : ''; ?>">
                    ⚙️ OTB Metadata
                </a>
            </nav>
        </div>
    </header>
    <div class="container">
