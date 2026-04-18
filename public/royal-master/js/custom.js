// StayFlow - custom.js optimisé
$(document).ready(function() {

    // Smooth scroll pour les ancres seulement
    $('a[href^="#"]').on('click', function(e) {
        var href = $(this).attr('href');
        if (href.length > 1 && $(href).length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $(href).offset().top - 70
            }, 600);
        }
    });

    // Navbar mobile toggle
    $('.navbar-toggler').on('click', function() {
        $('#navbarSupportedContent').toggleClass('show');
    });

    // Stellar parallax si disponible
    if (typeof $.fn.stellar !== 'undefined') {
        $.stellar({
            horizontalScrolling: false,
            responsive: true
        });
    }

});