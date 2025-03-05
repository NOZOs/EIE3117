<?php
/* @var $currentView View */
/* @var $customJS array */
/* @var $customCSS array */
/* @var $pageTitle string */
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $GLOBALS["appConfig"]["appTitle"] ?><?php echo (!empty($pageTitle) ? ' - ' . $pageTitle : '') ?></title>
        <!--CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/bootstrap-icons.css">
        <?php View::IncludeUIElements('css', 'common'); // Include common.css if exists ?>
        <?php foreach($customCSS as $css) { View::IncludeUIElements('css', $css); } // Include Custom CSS if exists ?>
        <?php View::IncludeUIElements('css', $currentView->getViewName()); // Include <viewname>.css CSS if exists  ?>
        <?php View::IncludeUIElements('css', 'style.css'); ?>
        <!-- JS -->
        <script
                src="/js/jquery-3.6.0.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" crossorigin="anonymous"
        ></script>
        <script src="/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <?php View::IncludeUIElements('js', 'common'); // Include common.js if exists ?>
        <?php foreach($customJS as $js) { View::IncludeUIElements('js', $js, true); } // Include Custom JS if exists ?>
        <?php View::IncludeUIElements('js', $currentView->getViewName(), true); // Include <viewname>.js JS if exists  ?>
    </head>
<body>
    <!-- Template Reference: https://getbootstrap.com/docs/5.0/examples/navbar-static/ -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><?php echo $GLOBALS["appConfig"]["appTitle"]; ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <?php
                    if (!SessionController::getInstance()->isUserLoggedIn()):
                    ?>
                    <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                    </li>
                    <?php
                    endif
                    ?>
                    <?php
                    if (SessionController::getInstance()->isUserLoggedIn()):
                    ?>
                    <li class="nav-item">
                    <a class="nav-link" href="/main">Main Page</a>
                    </li>
                    <?php
                    endif
                    ?>
                </ul>
                <?php
                if (SessionController::getInstance()->isUserLoggedIn()):
                ?>
                <ul class="navbar-nav d-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi-person-square"></i>
                            Logged in as <strong><?=SessionController::getInstance()->getUser()->username?></strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <li><a class="dropdown-item" href="/change_password">Change Password</a></li>
                            <li><a class="dropdown-item" href="/logout">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
                <?php
                endif
                ?>
                </div>

                    
        </div>
    </nav>

    <main class="container">
        <?php $currentView->showMainContent(compact(array_keys(get_defined_vars()))); ?>
    </main>
</body>
</html>