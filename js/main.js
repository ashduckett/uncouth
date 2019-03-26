function smoothScroll(target, duration) {
    var target = document.querySelector(target);
    var targetPosition = target.getBoundingClientRect().top - 100;
    var startingPosition = window.pageYOffset;
    var distance = targetPosition - startingPosition;
    var startTime = null;

    function animation(currentTime) {
        if (startTime == null) {
            startTime = currentTime;
        }

        var timeElapsed = currentTime - startTime;
        //var run = ease(timeElapsed, startingPosition, distance, duration);
        var run = ease(timeElapsed, startingPosition, targetPosition, duration);
        window.scrollTo(0, run);

        if (timeElapsed < duration) {
            requestAnimationFrame(animation);
        }
    }


    function ease(t, b, c, d) {
        t /= d / 2;
        if (t < 1) {
            return c / 2 * t * t + b;
        }
        t--;
        return -c / 2 * (t * (t - 2) - 1) + b;
    }

    requestAnimationFrame(animation);

}

function setNavOpacity() {
    const scrollPosition = window.scrollY;

    // Next get the client height
    const clientHeight = document.documentElement.clientHeight;

    // Get the % of the first section scrolled past.
    const percent = scrollPosition / clientHeight;
    const percentOfDesiredValue = 1 * percent;

    if (percent <= 1) {
        const bodyOverlay = document.querySelector('.navOverlay');
        bodyOverlay.style.opacity = percentOfDesiredValue;
    } else {
        const bodyOverlay = document.querySelector('.navOverlay');
        bodyOverlay.style.opacity = 1;
    }

}

function setBackgroundOpacity() {
    const scrollPosition = window.scrollY;

    // Next get the client height
    const clientHeight = document.documentElement.clientHeight;

    // Get the % of the first section scrolled past.
    const percent = scrollPosition / clientHeight;
    const percentOfDesiredValue = 0.4 * percent;

    if (percent <= 1) {
        const bodyOverlay = document.querySelector('.body-overlay');
        bodyOverlay.style.opacity = percentOfDesiredValue;
    } else {
        const bodyOverlay = document.querySelector('.body-overlay');
        bodyOverlay.style.opacity = 0.4;
    }
}


document.addEventListener('scroll', function(evt) {
    setBackgroundOpacity();
    setNavOpacity();
});

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

// Wait for elements to load before adding event handlers...
document.addEventListener('DOMContentLoaded', () => {
    
    // Get hold of the submit button for the contact form
    const submitButton = document.querySelector('.submitButton');
    submitButton.querySelector('i').classList.add('hidden');
    let isSubmitting = false;
    
    submitButton.addEventListener('click', (evt) => {
        evt.preventDefault();
        

        let errorsExist = false;

        // Get hold of the full name error field
        const fullNameError = document.querySelector('.fullNameError');

        // Get hold of the text inside the name field
        const fullNameTextFieldVal = document.querySelector('#fullNameTextField').value;
        
        // Show or hide error accordingly.
        if (fullNameTextFieldVal.trim() === '') {
            fullNameError.style.visibility = 'visible';
            errorsExist = true;
        } else {
            fullNameError.style.visibility = 'hidden';
        }

        // Get hold of the full name error field
        const emailError = document.querySelector('.emailError');

        // Get hold of the text inside the name field
        const emailTextFieldVal = document.querySelector('#emailTextField').value;

        // Show or hide error accordingly.
        if (emailTextFieldVal.trim() === '') {
            errorsExist = true;
            emailError.innerHTML = 'Please enter your email address';
            emailError.style.visibility = 'visible';
        } else {
            if (!validateEmail(emailTextFieldVal)) {
                emailError.innerHTML = 'Your email is not valid';
                errorsExist = true;
                emailError.style.visibility = 'visible';
            } else {
                emailError.style.visibility = 'hidden';
            }
        }

        
        
        // Now validate the enquiry

        // Get hold of the full name error field
        const enquiryError = document.querySelector('.enquiryError');

        // Get hold of the text inside the name field
        const enquiryTextFieldVal = document.querySelector('#enquiryTextField').value;

        // Show or hide error accordingly.
        if (enquiryTextFieldVal.trim() === '') {
            errorsExist = true;
            enquiryError.style.visibility = 'visible';
        } else {
            enquiryError.style.visibility = 'hidden';
        }
            
        
        
        if (isSubmitting === false) {
            
            
            
            if (!errorsExist) {
                submitButton.querySelector('i').classList.remove('hidden');
                submitButton.querySelector('.submit-text').style.display = 'none';
                submitButton.querySelector('i').classList.remove('visible');
                isSubmitting = true;
            
                const xhr = new XMLHttpRequest();

                xhr.open('POST', 'sendEmail.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        submitButton.innerHTML = '<span class="submit-text">Enquiry Sent!</span><i class="fa fa-cog fa-spin fa-fw"></i>';
                        submitButton.querySelector('i').classList.add('hidden');
                        isSubmitting = false;

                        setTimeout(() => {
                            submitButton.innerHTML = '<span class="submit-text">Submit</span><i class="fa fa-cog fa-spin fa-fw"></i>';
                            submitButton.querySelector('i').classList.add('hidden');
                            document.querySelector('#fullNameTextField').value = '';
                            document.querySelector('#emailTextField').value = '';
                            document.querySelector('#enquiryTextField').value = '';
                        }, 2000);
                    } else if (xhr.status !== 200) {
                        alert('Request failed.  Returned status of ' + xhr.status);
                    }
                };
                xhr.send(encodeURI('name=' + fullNameTextFieldVal + '&email=' + emailTextFieldVal + '&enquiry=' + enquiryTextFieldVal));
            }
        }
    });
    
    setBackgroundOpacity();

    document.querySelector('#menuItemPortfolio').addEventListener('click', function(evt) {
        evt.preventDefault();
        smoothScroll('.portfolio', 1000);
    });

    document.querySelector('#learnMore').addEventListener('click', function(evt) {
        evt.preventDefault();
        smoothScroll('.portfolio', 1000);
    });

    document.querySelector('#menuItemAbout').addEventListener('click', function(evt) {
        evt.preventDefault();
        smoothScroll('.about', 1000);
    });

    document.querySelector('#menuItemServices').addEventListener('click', function(evt) {
        evt.preventDefault();
        smoothScroll('.servicesContainer', 1000);
    });


    document.querySelector('#menuItemContact').addEventListener('click', function(evt) {
        evt.preventDefault();
        smoothScroll('.contact', 1000);
    });

    if (document.querySelector('.hamburger') !== null) {
        document.querySelector('.hamburger').addEventListener('click', function(evt) {
            this.classList.toggle('isActive');

            // Get hold of the mobile menu and set it to be active as well
            document.querySelector('.mobileMenu').classList.toggle('active');
        });
    }

    document.querySelector('.mobileMenu #menuItemHome').addEventListener('click', (evt) => {
        evt.preventDefault();
        smoothScroll('body', 1000);
        document.querySelector('.mobileMenu').classList.toggle('active');
        document.querySelector('.hamburger').classList.toggle('isActive');
    });

    document.querySelector('.mobileMenu #menuItemPortfolio').addEventListener('click', (evt) => {
        evt.preventDefault();
        smoothScroll('.portfolio', 1000);
        document.querySelector('.mobileMenu').classList.toggle('active');
        document.querySelector('.hamburger').classList.toggle('isActive');
    });

    document.querySelector('.mobileMenu #menuItemAbout').addEventListener('click', (evt) => {
        evt.preventDefault();
        smoothScroll('.about', 1000);
        document.querySelector('.mobileMenu').classList.toggle('active');
        document.querySelector('.hamburger').classList.toggle('isActive');
    });

    document.querySelector('.mobileMenu #menuItemServices').addEventListener('click', (evt) => {
        evt.preventDefault();
        smoothScroll('.servicesContainer', 1000);
        document.querySelector('.mobileMenu').classList.toggle('active');
        document.querySelector('.hamburger').classList.toggle('isActive');
    });

    document.querySelector('.mobileMenu #menuItemContact').addEventListener('click', (evt) => {
        evt.preventDefault();
        smoothScroll('.contact', 1000);
        document.querySelector('.mobileMenu').classList.toggle('active');
        document.querySelector('.hamburger').classList.toggle('isActive');
    });
}, false);