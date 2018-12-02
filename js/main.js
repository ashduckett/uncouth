function smoothScroll(target, duration) {
    var target = document.querySelector(target);
    var targetPosition = target.getBoundingClientRect().top;
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



// Wait for elements to load before adding event handlers...
document.addEventListener('DOMContentLoaded', () => {
    
    document.querySelector('.intro .nextArrow').addEventListener('click', function(evt) {
        evt.preventDefault();
        smoothScroll('.portfolio', 1000);
    });

    document.querySelector('.portfolio .nextArrow').addEventListener('click', function(evt) {
        evt.preventDefault();
        smoothScroll('.about', 1000);
    });

    document.querySelector('.about .nextArrow').addEventListener('click', function(evt) {
        evt.preventDefault();
        smoothScroll('.knowledge', 1000);
    });
    



}, false);