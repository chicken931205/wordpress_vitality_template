jQuery(document).ready(function($) {
    var $window = $(window);
    var $document = $(document);
    var $stickyHeader = $('.sticky-header');
    var $nav = $stickyHeader.find('nav');
    var $progressPercentage = $('.progress-percentage');
    var $sidebarNav = $('.sidebar-nav');
    var $progressRing = $('.progress-ring circle:last-child');
    var sections = ['benefits', 'key-ingredients', 'top-5'];

    function updateProgress() {
        var scrollPosition = $window.scrollTop();
        var documentHeight = $document.height() - $window.height();
        var progress = Math.round((scrollPosition / documentHeight) * 100);
        $progressPercentage.text(progress + '%');
        $('.sidebar .percentage').text(progress + '%');
        
        // Update progress ring
        var circumference = 2 * Math.PI * 28; // 28 is the radius of the circle
        var offset = circumference - (progress / 100) * circumference;
        $progressRing.css('stroke-dashoffset', offset);
    }

    function updateActiveSection() {
        var scrollPosition = $window.scrollTop();

        sections.forEach(function(section) {
            var $section = $('#' + section);
            if ($section.length) {
                var sectionTop = $section.offset().top - 100;
                var sectionBottom = sectionTop + $section.height();

                if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                    $nav.find('a').removeClass('active');
                    $nav.find('a[href="#' + section + '"]').addClass('active');
                    $sidebarNav.find('a').removeClass('active');
                    $sidebarNav.find('a[href="#' + section + '"]').addClass('active');
                }
            }
        });
    }

    $window.on('scroll', function() {
        updateProgress();
        updateActiveSection();
    });

    $nav.find('a').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(target).offset().top - 60
        }, 500);
    });

    $sidebarNav.find('a').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(target).offset().top - 60
        }, 500);
    });

    // Initialize progress and active section on page load
    updateProgress();
    updateActiveSection();
});
