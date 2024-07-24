jQuery(document).ready(function($) {
    var $window = $(window);
    var $document = $(document);
    var $whatyoulearn = $('div.what-you-learn');
    var $progressRing = $('.reading-progress svg.progress-circle circle:last-child');
    var $navbar = $('.section-1 .nav-bar');

    var offsetWhatYouLearn = $whatyoulearn.offset();
    var offsetNavbar = $navbar.offset();
    
    function updateProgress() {
        var scrollPosition = $window.scrollTop();
        var documentHeight = $document.height() - $window.height();
        var progress = Math.round((scrollPosition / documentHeight) * 100);        
        
        if (offsetWhatYouLearn.top < scrollPosition) {
            $whatyoulearn.addClass('fixed');
        } else {
            $whatyoulearn.removeClass('fixed');
        }

        if (offsetNavbar.top < scrollPosition && (scrollPosition - offsetNavbar.top >  20)) {
            $navbar.addClass('fixed');
        } else {
            $navbar.removeClass('fixed');
        }

        $('.right-sidebar .percent').text(progress + '%');
        
        // Update progress ring
        var circumference = 2 * Math.PI * 34; // 34 is the radius of the circle
        var offset = circumference - (progress / 100) * circumference;
        $progressRing.css('stroke-dashoffset', offset);
    }

    $window.on('scroll', function() {
        updateProgress();
    });

    // Initialize progress and active section on page load
    updateProgress();
});
