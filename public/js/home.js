function loadMoreData(id = 0, url) {
    $.ajax({
        type: 'POST',
        url: url,
        data: {id: id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#load_more_button').remove();
            $('#loadData').append(data);
        }
    });
}
jQuery(document).ready(function () {
    var $ = jQuery;
    $(document).on("click", ".st_FlagMenu .dropdown-toggle", function () {
        $(this).parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
        return false;
    });
    $(document).on("click", ".st_FlagItem__link", function () {
        $(this).parent().hide();
        var URL = $('#report_url').val();
        if ($('#login_user_id').val() == '') {
            window.location.href = $('#login_url').val();
        } else {
            $.ajax({
                type: 'POST',
                url: URL,
                data: {post_id: $(this).parent().data('postid'), type: 'article', 'report': $(this).find('span').text()},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    alert('Your report successfully submited.');
                }
            });
        }
    });
    $(document).on("click", "body", function () {
        $('.st_FlagMenu .dropdown-toggle').parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").hide();
        return false;
    });
    $(document).on("click", "#js-user-nav-menu", function () {
        $(".UserMenu_UserMenu  ul.dropdown-menu.dropdown-menu-right").toggle();
    });
    $(".regular").slick({
        dots: false,
        arrows: false,
        infinite: true,
        slidesToShow: 5,
        autoplay: true,
        autoplaySpeed: 3000,
        slidesToScroll: 1,
        vertical: true,
        verticalSwiping: true,
        pauseOnHover: true,
        pauseOnFocus: true
    });
    $(".regular_1").slick({
        dots: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 991,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '100px',
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $(document).on("click", ".header-hamburger-btn", function () {
        $(".h-hamburger-line").toggleClass('hamburger__line--open');
        $(".mob-menu").toggleClass("show-mob-menu");
    });
    $(document).on("click", ".secondary-nav__list-item", function () {
        $(this).find('.secondary-nav__menu').toggleClass('show');
    });
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function () {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            jQuery(".header").removeClass('header--sticky-condensed');
            jQuery(".header").addClass('header--sticky-full');
        } else {
            jQuery(".header").addClass('header--sticky-condensed');
            jQuery(".header").removeClass('header--sticky-full');
        }
        prevScrollpos = currentScrollPos;
    };
    $(document).on("click", ".header-hamburger-btn", function () {
        $('.header').toggleClass('header--fixed');
        $('.header').removeClass("header--sticky-full");
        $('.header').removeClass("header--sticky-condensed");
        $('body').toggleClass("over-class");
    });
    $(document).on("click", ".autocomplete input", function () {
        $('.fp-helper__wrapper.fp-helper--closed').show();
    });
    $(document).mouseup(function (e) {
        var container = $(".fp-helper__wrapper.fp-helper--closed");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            container.hide();
        }
    });
    $(document).on('click', '.share-button', function () {
        $this = $(this);
        if (navigator.share) {
            navigator.share({
                title: $this.data('title'),
                url: window.location.href + $this.data('url') + '?utm_source=share-mobile&utm_medium=web&utm_campaign=share'
            }).then(() => {
                console.log('Thanks for sharing!');
            })
                    .catch(console.error);
        }
    });
    $(document).on('click', '#load_more_button', function () {
        var id = $(this).data('id');
        var url = $(this).data('url');
        //console.log(id);
        $('#load_more_button').html('<b>Loading...</b>');
        loadMoreData(id, url);
    });
    $(document).on('click', '.like_button-post', function () {
        var URL = $('#like_url').val();
        var $this = $(this);
        if ($('#login_user_id').val() == '') {
            window.location.href = $('#login_url').val();
        } else {
            $.ajax({
                type: 'POST',
                url: URL,
                data: {post_id: $(this).data('postid'), type: 'article'},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $this.html(data.html);
                    $this.attr('data-likecount', data.count);
                }
            });
        }
    });
});