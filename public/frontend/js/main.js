(function ($) {
    ("user strict");

    // preloader
    $(window).on("load", function () {
        $(".preloader").fadeOut(1000);
        var img = $(".bg_img");
        img.css("background-image", function () {
            var bg = "url(" + $(this).data("background") + ")";
            return bg;
        });
    });

    //Create Background Image
    (function background() {
        let img = $(".bg_img");
        img.css("background-image", function () {
            var bg = "url(" + $(this).data("background") + ")";
            return bg;
        });
    })();

    (function background() {
        let img = $(".bg_img-2");
        img.css("background-image", function () {
            var bg = "url(" + $(this).data("background") + ")";
            return bg;
        });
    })();

    // lightcase
    $(window).on("load", function () {
        $("a[data-rel^=lightcase]").lightcase();
    });

    // header-fixed
    var fixed_top = $(".header-section");
    $(window).on("scroll", function () {
        if ($(window).scrollTop() > 100) {
            fixed_top.addClass("animated fadeInDown header-fixed");
        } else {
            fixed_top.removeClass("animated fadeInDown header-fixed");
        }
    });

    // navbar-click
    $(".navbar li a").on("click", function () {
        var element = $(this).parent("li");
        if (element.hasClass("show")) {
            element.removeClass("show");
            element.children("ul").slideUp(500);
        } else {
            element.siblings("li").removeClass("show");
            element.addClass("show");
            element.siblings("li").find("ul").slideUp(500);
            element.children("ul").slideDown(500);
        }
    });

    // scroll-to-top
    var ScrollTop = $(".scrollToTop");
    $(window).on("scroll", function () {
        if ($(this).scrollTop() < 100) {
            ScrollTop.removeClass("active");
        } else {
            ScrollTop.addClass("active");
        }
    });

    // testimonial
    var swiper = new Swiper(".testimonial-slider", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        autoplay: {
            speed: 1000,
            delay: 3000,
        },
        speed: 1000,
        breakpoints: {
            1199: {
                slidesPerView: 1,
            },
            991: {
                slidesPerView: 1,
            },
            767: {
                slidesPerView: 1,
            },
            575: {
                slidesPerView: 1,
            },
        }
    });

    // sidebar
    $(".sidebar-menu-item > a").on("click", function () {
        var element = $(this).parent("li");
        if (element.hasClass("active")) {
            element.removeClass("active");
            element.children("ul").slideUp(500);
        } else {
            element.siblings("li").removeClass("active");
            element.addClass("active");
            element.siblings("li").find("ul").slideUp(500);
            element.children("ul").slideDown(500);
        }
    });

    window.addEventListener('resize', function () {
        if (screen.width > 991) {
            $('.sidebar__menu').show();
        } else {
            $('.sidebar__menu').hide();
        }
    }, true);

    //sidebar Menu
    $(document).on("click", ".navbar__expand", function () {
        $(".sidebar").toggleClass("active");
        $(".navbar-wrapper").toggleClass("active");
        $(".body-wrapper").toggleClass("active");
    });

    // Mobile Menu
    $(".sidebar-mobile-menu").on("click", function () {
        $(".sidebar__menu").slideToggle();
    });

    // faq
    $(".faq-wrapper .faq-title").on("click", function (e) {
        var element = $(this).parent(".faq-item");
        if (element.hasClass("open")) {
            element.removeClass("open");
            element.find(".faq-content").removeClass("open");
            element.find(".faq-content").slideUp(300, "swing");
        } else {
            element.addClass("open");
            element.children(".faq-content").slideDown(300, "swing");
            element
                .siblings(".faq-item")
                .children(".faq-content")
                .slideUp(300, "swing");
            element.siblings(".faq-item").removeClass("open");
            element.siblings(".faq-item").find(".faq-title").removeClass("open");
            element.siblings(".taq-item").find(".faq-content").slideUp(300, "swing");
        }
    });

    var swiper = new Swiper(".brand-slider", {
        slidesPerView: 6,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            speed: 1000,
            delay: 3000,
        },
        speed: 1000,
        breakpoints: {
            1199: {
                slidesPerView: 5,
            },
            991: {
                slidesPerView: 4,
            },
            767: {
                slidesPerView: 3,
            },
            575: {
                slidesPerView: 2,
            },
        },
    });
    // togol feature
    $(document).ready(function () {
        $.each($(".switch-toggles"), function (index, item) {
            var firstSwitch = $(item).find(".switch").first();
            var lastSwitch = $(item).find(".switch").last();
            if (firstSwitch.attr('data-value') == null) {
                $(item).find(".switch").first().attr("data-value", true);
                $(item).find(".switch").last().attr("data-value", false);
            }
            if ($(item).hasClass("active")) {
                $(item).find('input').val(firstSwitch.attr("data-value"));
            } else {
                $(item).find('input').val(lastSwitch.attr("data-value"));
            }
        });
    });

    $('.switch-toggles .switch').on('click', function () {
        $(this).parents(".switch-toggles").toggleClass('active');
        $(this).parents(".switch-toggles").find("input").val($(this).attr("data-value"));
    });


    //toggle passwoard
    $(document).ready(function () {
        $(".show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('.show_hide_password input').attr("type") == "text") {
                $('.show_hide_password input').attr('type', 'password');
                $('.show_hide_password i').addClass("fa-eye-slash");
                $('.show_hide_password i').removeClass("fa-eye");
            } else if ($('.show_hide_password input').attr("type") == "password") {
                $('.show_hide_password input').attr('type', 'text');
                $('.show_hide_password i').removeClass("fa-eye-slash");
                $('.show_hide_password i').addClass("fa-eye");
            }
        });
    });

    $(document).ready(function () {
        $(".show_hide_password-2 a").on('click', function (event) {
            event.preventDefault();
            if ($('.show_hide_password-2 input').attr("type") == "text") {
                $('.show_hide_password-2 input').attr('type', 'password');
                $('.show_hide_password-2 i').addClass("fa-eye-slash");
                $('.show_hide_password-2 i').removeClass("fa-eye");
            } else if ($('.show_hide_password-2 input').attr("type") == "password") {
                $('.show_hide_password-2 input').attr('type', 'text');
                $('.show_hide_password-2 i').removeClass("fa-eye-slash");
                $('.show_hide_password-2 i').addClass("fa-eye");
            }
        });
    });

    $(document).ready(function () {
        $(".show_hide_password-3 a").on('click', function (event) {
            event.preventDefault();
            if ($('.show_hide_password-3 input').attr("type") == "text") {
                $('.show_hide_password-3 input').attr('type', 'password');
                $('.show_hide_password-3 i').addClass("fa-eye-slash");
                $('.show_hide_password-3 i').removeClass("fa-eye");
            } else if ($('.show_hide_password-3 input').attr("type") == "password") {
                $('.show_hide_password-3 input').attr('type', 'text');
                $('.show_hide_password-3 i').removeClass("fa-eye-slash");
                $('.show_hide_password-3 i').addClass("fa-eye");
            }
        });
    });


    //Notification
    $('.notification-icon').on('click', function (e) {
        e.preventDefault();
        if ($('.notification-wrapper').hasClass('active')) {
            $('.notification-wrapper').removeClass('active');
            $('.body-overlay').removeClass('show');
        } else {
            $('.notification-wrapper').addClass('active');
            $('.body-overlay').addClass('show');
        }
    });
    $('#body-overlay').on('click', function (e) {
        e.preventDefault();
        $('.notification-wrapper').removeClass('active');
        $('.body-overlay').removeClass('show');
    });

    // dashboard-list
    $('.dashboard-list-item').on('click', function (e) {
        var element = $(this).parent('.dashboard-list-item-wrapper');
        if (element.hasClass('show')) {
            element.removeClass('show');
            element.find('.preview-list-wrapper').removeClass('show');
            element.find('.preview-list-wrapper').slideUp(300, "swing");
        } else {
            element.addClass('show');
            element.children('.preview-list-wrapper').slideDown(300, "swing");
            element.siblings('.dashboard-list-item-wrapper').children('.preview-list-wrapper').slideUp(300, "swing");
            element.siblings('.dashboard-list-item-wrapper').removeClass('show');
            element.siblings('.dashboard-list-item-wrapper').find('.dashboard-list-item').removeClass('show');
            element.siblings('.dashboard-list-item-wrapper').find('.preview-list-wrapper').slideUp(300, "swing");
        }
    });



    // input toggle
    $(".baby-feature").addClass('active');
    $("#switchpet").click(function () {
        $(".pet-feature").addClass('active');
        $(".baby-feature").removeClass('active');
    });
    $("#switchbaby").click(function () {
        $(".baby-feature").addClass('active');
        $(".pet-feature").removeClass('active');
    });

    $("#pet-form").click(function () {
        $(".pet-appointment").addClass('active');
        $(".baby-appointment").removeClass('active');
    });
    $("#baby-form").click(function () {
        $(".baby-appointment").addClass('active');
        $(".pet-appointment").removeClass('active');
    });

    // Get all elements with class 'item'
    const items = document.querySelectorAll('.baby-choice-area a');

    // Add click event listener to each item
    items.forEach(item => {
        item.addEventListener('click', function () {
            // Remove 'active' class from all items
            items.forEach(item => item.classList.remove('active'));
            // Add 'active' class to the clicked item
            this.classList.add('active');
        });
    });



})(jQuery);

//Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
// window.onscroll = function () {
//     scrollFunction();
// };

// function scrollFunction() {
//   if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
//     mybutton.style.display = "block";
//   } else {
//     mybutton.style.display = "none";
//   }
// }
// When the user clicks on the button, scroll to the top of the document
// mybutton.addEventListener("click", backToTop);

// function backToTop() {
//     document.body.scrollTop = 0;
//     document.documentElement.scrollTop = 0;
// }

// gallery
const slider = new Swiper(".slider", {
    loop: true,
    speed: 500,
    centeredSlides: true,
    slidesPerView: 3,
    navigation: {
        prevEl: ".button-prev",
        nextEl: ".button-next",
    },
    on: {
        slideChangeTransitionStart: function () {
            setBeforePrevAfterNext(this);
        },
    },
});

function setBeforePrevAfterNext($swiper) {
    let prev = $swiper.el.querySelector(".swiper-slide-prev");
    let next = $swiper.el.querySelector(".swiper-slide-next");
    let duplicate_prev = $swiper.el.querySelector(".swiper-slide-duplicate-prev");
    let duplicate_next = $swiper.el.querySelector(".swiper-slide-duplicate-next");
    let before_prev = prev.previousElementSibling;
    let after_next = next.nextElementSibling;

    $swiper.el
        .querySelectorAll(".swiper-slide-before-prev")
        .forEach((element) => {
            element.classList.remove("swiper-slide-before-prev");
        });
    $swiper.el.querySelectorAll(".swiper-slide-after-next").forEach((element) => {
        element.classList.remove("swiper-slide-after-next");
    });

    before_prev.classList.add("swiper-slide-before-prev");
    after_next.classList.add("swiper-slide-after-next");

    if (duplicate_prev && duplicate_prev.previousElementSibling) {
        duplicate_prev.previousElementSibling.classList.add(
            "swiper-slide-before-prev"
        );
    }

    if (duplicate_next && duplicate_next.nextElementSibling) {
        duplicate_next.nextElementSibling.classList.add("swiper-slide-after-next");
    }
}

function openDeleteModal(URL, target, message, actionBtnText = "Remove", method = "DELETE") {
    if (URL == "" || target == "") {
        return false;
    }

    if (message == "") {
        message = "Are you sure toll delete ?";
    }
    var method = `<input type="hidden" name="_method" value="${method}">`;

    openModalByContent(
        {
            content: `<div class="card modal-alert border-0">
                    <div class="card-body">
                        <form method="POST" action="${URL}">
                            <input type="hidden" name="_token" value="${laravelCsrf()}">
                            ${method}
                            <div class="head mb-3">
                                ${message}
                                <input type="hidden" name="target" value="${target}">
                            </div>
                            <div class="foot d-flex align-items-center justify-content-between">
                                <button type="button" class="modal-close btn btn--info rounded text-light">Close</button>
                                <button type="submit" class="alert-submit-btn btn btn--danger btn-loading rounded text-light">${actionBtnText}</button>
                            </div>
                        </form>
                    </div>
                </div>`,
        },

    );
}

//Profile Upload
function proPicURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var preview = $(input).parents('.preview-thumb').find('.profilePicPreview');
            $(preview).css('background-image', 'url(' + e.target.result + ')');
            $(preview).addClass('has-image');
            $(preview).hide();
            $(preview).fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(".profilePicUpload").on('change', function () {
    proPicURL(this);
});

$(".remove-image").on('click', function () {
    $(".profilePicPreview").css('background-image', 'none');
    $(".profilePicPreview").removeClass('has-image');
});
