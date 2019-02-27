<?php
    require_once('database/PortfolioItem.php');

    // Obtain id
    $receivedId = $_GET['id'];
    $portfolioItem = PortfolioItem::findById($receivedId);
    require_once('partials/header.php');
?>

<body id="caseStudy">

    <div class="body-overlay"></div>
    <header class="header">
    <nav>
        <div class="navOverlay"></div>
        <a href="index.php">
            <div class="header__logo-box">
                <img src="img/logo.png" alt="Logo" class="header__logo">
                <div class="separatorAndText"></div>
                <span class="brandingText">Uncouth Studios</span>
            </div>
        </a>
        <ul class="desktopMenu">
            <li><a id="menuItemHome" href="#">Home</a></li>
            <li><a id="menuItemPortfolio" href="#">Portfolio</a></li>
            <li><a id="menuItemAbout" href="#">About</a></li>
            <li><a id="menuItemServices" href="#">Services</a></li>
            <li><a id="menuItemContact" href="#">Contact</a></li>
        </ul>
        <div class="hamburger">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
        
            <ul class="mobileMenu">
                <li><a id="menuItemHome" href="#">Home</a></li>
                <li><a id="menuItemPortfolio" href="#">Portfolio</a></li>
                <li><a id="menuItemAbout" href="#">About</a></li>
                <li><a id="menuItemServices" href="#">Services</a></li>
                <li><a id="menuItemContact" href="#">Contact</a></li>
            </ul>
        
    </nav>



        <div class="headingOverlay"></div>
        <img class="caseStudyHeaderImg" src=" <?php echo $portfolioItem->getValue('heading_image_path'); ?>">
    </header>
    <section class="topSources sources">
        <div>
            <a href="<?php echo $portfolioItem->getValue('github_url'); ?>"><i class="icon fab fa-github"></i>View the Code</a>
        </div>
        <div>
            <a href="<?php echo $portfolioItem->getValue('rebrand_site_url'); ?>"><i class="fas fa-bolt"></i>View a Live Demo</a>
        </div>
    </section>
    <section class="caseStudyOverview">
        <div class="textAndImageContainer">
            <div class="text">
                <h2><?php echo $portfolioItem->getValue('title'); ?></h2>
                <p class="standardCaseStudyText">
                    <?php echo $portfolioItem->getValue('entry_text'); ?>
                </p>
            </div>
            <div class="image">
                <img src="<?php echo $portfolioItem->getValue('overview_image'); ?>">
            </div>
        </div>
    </section>
    <section class="product">
        <div class="headerAndText">
            <h2 class="productHeader">The Product</h2>
            <p class="productText standardCaseStudyText" >
                <?php echo $portfolioItem->getValue('detail_text'); ?>
            </p>
        </div>
        <?php
            $images =  json_decode($portfolioItem->getValue('detail_images'));
        ?>

        <img class="productImage" src="<?php echo $images[0]; ?>">
        <img class="productImage" src="<?php echo $images[1]; ?>">

    </section>
    <section class="sources">
        <div>
            <a href="<?php echo $portfolioItem->getValue('github_url'); ?>"><i class="icon fab fa-github"></i>View the Code</a>
        </div>
        <div>
            <a href="<?php echo $portfolioItem->getValue('rebrand_site_url'); ?>"><i class="fas fa-bolt"></i>View a Live Demo</a>
        </div>
    </section>
    <footer class="footer">
                <div class="branding">
                    <img src="img/logo.png" alt="Logo" class="footer__logo">
                    <div class="separatorAndText"></div>
                    <span class="brandingText">Uncouth Studios</span>
                </div>

                <div class="socialMediaIcons">
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="https://twitter.com/uncouthstudios"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.facebook.com/Uncouth-Studios-2197410427253703"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </footer>

</body>
</html>