<?php require_once('database/PortfolioItem.php'); ?>
<?php require_once('partials/header.php'); ?>
    <body>
        <div id="home">
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
                <h1 class="header__text-box">
                    <span class="heading-primary--main">Uncouth Studios</span>
                    <span class="heading-primary--sub">Ethical Web Development</span>
                    <div class="stackContainer">
                        <img class="stackIcon" src="img/html.svg">
                        <img class="stackIcon" src="img/css.svg">
                        <img class="stackIcon" src="img/sass.svg">
                        <img class="stackIcon" src="img/javascript.svg">
                        <img class="stackIcon" src="img/node.svg">
                        <img class="stackIcon" src="img/react.svg">
                        <img class="stackIcon" src="img/php.svg">
                        <!-- <img class="stackIcon" src="img/swift.svg"> -->
                        <!-- <img class="stackIcon" src="img/java.svg"> -->
                        <!-- <img class="stackIcon" src="img/android.svg"> -->
                        <img class="stackIcon" src="img/ios.svg">
                    </div>
                
                    <a id="learnMore" href="#" class="btn btn--white btn--animated">Learn More</a>
                </h1>
            </header>
            <section class="portfolio">
                <div class="websiteCollection">
                    
                    <?php

                        $portfolioItems = PortfolioItem::getAll();

                        foreach($portfolioItems as $index => $portfolioItem) {
                            echo '<div class="portfolioItem">';

                            if ($index === 0) {
                                echo '
                                    <div class="portfolioHeader">
                                        <span class="super">Port</span>
                                        <span class="sub">folio</span>
                                    </div>
                                ';
                            }
                                echo '

                                <div class="imageContainer">
                                    <a href="portfolio_item.php?id=' . $portfolioItem->getValue('id') . '"><img src="' . $portfolioItem->getValue('heading_image_path') . '"></a>
                                </div>
                            </div>
                                ';
                        }



                        ?>
            </section>
            <section class="about">
                <div class="aboutHeaderAndText">
                    <h2 class="aboutHeader">About</h2>
                    <div class="aboutTextContainer">
                    <p class="aboutText">
                        After observing and working in companies that strike me as dishonest and pretentious I decided to pull something out of
                        the ashes of those experiences. 
                    </p>
                    <p class="aboutText">
                        Uncouth Studios is a reaction and that means that it's a company that believes
                        in honesty to its clients, no pretentiousness and saving you money where it's possible. Development doesn't need
                        tonnes of red tape; a simple contract, continual updates on progress and a friendly, honest, attitude from both sides
                        are all that's needed.
                    </p>
                    <p class="aboutText">
                        Uncouth Studios offers websites of all sizes, from static single page websites, to multipage database driven interactive web applications.
                        If you think something would be better as a phone app for either Android or iPhone, let me know and I will see what I can do.
                    </p>
                </div>
                </div>
            </section>
            <section class="servicesContainer">
                <!-- <div class="servicesContainerOverlay"></div> -->
                <h2 class="servicesTitle">Services</h2>
                <div class="services">
                        
                    <div class="service">
                        <img class="serviceImage" src="img/iMac.svg">
                        <h2>Websites</h2>
                        <p>
                            Websites and web apps developed in the latest technologies.
                        </p>
                    </div>
                    <div class="service">
                        <img class="serviceImage" src="img/design.svg">
                        <h2>Design</h2>
                        <p>
                            Need a design before you come to me? Get in touch and I'll communicate your needs to a designer.
                        </p>
                    </div>
                    <div class="service">
                        <img class="serviceImage" src="img/iPhone.svg">
                        <h2>Phone Apps</h2>
                        <p>
                            If you need a native phone app, I'd be more than happy to help.
                        </p>
                    </div>
                    <div class="service">
                        <img class="serviceImage" src="img/handshake.svg">
                        <h2>Partnership</h2>
                        <p>
                            Don't have any funds? Maybe we can make something a joint venture.
                        </p>
                    </div>
                    <div class="service">
                        <img class="serviceImage" src="img/screwdriver.svg">
                        <h2>Maintenance</h2>
                        <p>
                            I won't leave your site in the dark. If you have a problem I'll fix it and if you want additions we'll get them sorted.
                        </p>
                    </div>

                </div>
            </section>
            <section class="contact"> 
                <form class="contactForm">
                    <div class="fullNameField formField">
                        <label>Full Name</label>
                        <input id="fullNameTextField" type="text">
                        <div class="fullNameError error">Please enter your name</div>
                    </div>
                    <div class="emailField formField">
                        <label>Email</label>
                        <input id="emailTextField" type="text">
                        <div class="emailError error">Please enter your email</div>
                    </div>
                    <div class="enquiryField formField">
                        <label>Enquiry</label>
                        <textarea id="enquiryTextField"></textarea>
                        <div class="enquiryError error">Please enter your enquiry</div>
                    </div>
                    <div class="submitButtonContainer">
                        <a class="submitButton" href="#"><span class="submit-text">Submit</span><i class="fa fa-cog fa-spin fa-fw"></i></a>
                    </div>
                </form>
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
        </div>
    </body>
</html>