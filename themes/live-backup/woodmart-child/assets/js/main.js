window.addEventListener('load', function () {

    const navContainer = document.querySelector("#nav-container")
    const button = document.querySelector("#ham");
    const nav = document.querySelector("#primary-nav");
    const body = document.body;


    function toggleClass(element, className) {
        element.classList.toggle(className);
    }

    button.addEventListener("click", () => {

        toggleClass(navContainer, "active");
        toggleClass(button, "active");
        toggleClass(nav, "active");
        toggleClass(body, "no-scroll");

        console.log('click');
    });



    function catSwiper() {
        const catPageSwiper = document.getElementById('cat-page-swiper');

        if (!catPageSwiper) return;

        const swiper = new Swiper(catPageSwiper, {
            // Default parameters
            slidesPerView: 2,
            spaceBetween: 10,
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 320px
                320: {
                    spaceBetween: 20,
                    slidesPerView: 2.5
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 3,
                    spaceBetween: 40
                }
            }
        });


    }
    catSwiper()

    function locationLandingSix() {
        const slider = document.getElementById('card-slider-six');
        if (!slider || typeof Swiper === 'undefined') return;

        const paginationEl = slider.querySelector('.swiper-pagination');

        const swiper = new Swiper(slider, {
            slidesPerView: 2,
            spaceBetween: 5,

            breakpoints: {
                480: { slidesPerView: 2 },
                960: { enabled: false }
            },

            pagination: paginationEl ? {
                el: paginationEl,
                clickable: true,
            } : undefined,
        });
    }



    function locationLandingThree() {

        const slider = document.getElementById('card-slider-three');

        if (!slider) return;


        const swiper = new Swiper(slider, {
            slidesPerView: 1.5,
            spaceBetween: 5,

            breakpoints: {
                960: {
                    slidesPerView: 3,
                }
            },

            // pagination: {
            //     el: swiper.querySelector('.swiper-pagination-three'),
            //     clickable: true,
            // },
        });
    }

    locationLandingThree();



    function cardSliderThree() {
        const slider = document.getElementById('card-slider-three');
        if (!slider) return;

        const swiper = new Swiper(slider, {
            slidesPerView: 1,
            spaceBetween: 5,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                    spaceBetween: 10
                }
            },
            pagination: {
                el: slider.querySelector('.swiper-pagination-three'),
                clickable: true,
            },
        });
    }

    cardSliderThree()


    function homeCatSlider(id) {
        const homePageCatLatestOne = document.getElementById('hp-cat-latest-' + id);

        if (!homePageCatLatestOne) return;

        const swiper = new Swiper(homePageCatLatestOne, {

            slidesPerView: 1.5,
            spaceBetween: 10,

            breakpoints: {
                765: {
                    enabled: false,
                },
            }
        });

        console.log(homePageCatLatestOne);
    }
    // 512
    homeCatSlider(39)
    homeCatSlider(520)
    homeCatSlider(513)
    homeCatSlider(515)


    console.log('asdfsjnfds');
})


document.addEventListener('DOMContentLoaded', () => {
    const triggers = document.querySelectorAll('.faq__trigger');

    const openItem = (trigger) => {
        const content = document.getElementById(trigger.getAttribute('aria-controls'));
        content.hidden = false;
        trigger.setAttribute('aria-expanded', 'true');

        requestAnimationFrame(() => {
            content.classList.add('is-open');
            content.style.maxHeight = content.scrollHeight + 'px';
        });
    };

    const closeItem = (trigger) => {
        const content = document.getElementById(trigger.getAttribute('aria-controls'));
        trigger.setAttribute('aria-expanded', 'false');
        content.style.maxHeight = null;
        content.classList.remove('is-open');
        setTimeout(() => { content.hidden = true; }, 300);
    };

    triggers.forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const isOpen = trigger.getAttribute('aria-expanded') === 'true';

            // Close all others
            triggers.forEach((other) => {
                if (other !== trigger) closeItem(other);
            });

            // Toggle current
            isOpen ? closeItem(trigger) : openItem(trigger);
        });
    });

    // 👉 Open first FAQ by default
    if (triggers.length > 0) {
        openItem(triggers[0]);
    }

    //SIDEBAR NAV
    function sidebarNav() {
        const toggleButton = document.querySelector(".sidenav-toggle");
        const sidenav = document.querySelector(".sidenav");

        if (toggleButton && sidenav) {
            toggleButton.addEventListener("click", () => {
                const expanded = toggleButton.getAttribute("aria-expanded") === "true";

                toggleButton.setAttribute("aria-expanded", String(!expanded));

                if (expanded) {
                    sidenav.classList.remove("is-open");
                    sidenav.style.maxHeight = "0px";
                } else {
                    sidenav.classList.add("is-open");
                    sidenav.style.maxHeight = `${sidenav.scrollHeight}px`;
                }
            });

            window.addEventListener("resize", () => {
                if (window.innerWidth > 768) {
                    sidenav.style.maxHeight = "";
                    sidenav.classList.remove("is-open");
                    toggleButton.setAttribute("aria-expanded", "false");
                }
            });
        }


        const headings = document.querySelectorAll("h2[id]");
        const navLinks = document.querySelectorAll(".sidenav a");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    const id = entry.target.getAttribute("id");
                    const link = document.querySelector(`.sidenav a[href="#${id}"]`);

                    if (entry.isIntersecting) {
                        navLinks.forEach((link) => link.classList.remove("is-active"));
                        if (link) link.classList.add("is-active");
                    }
                });
            },
            {
                root: null,
                rootMargin: "-40% 0px -50% 0px", // triggers when section is near middle
                threshold: 0
            }
        );

        headings.forEach((section) => observer.observe(section));

        console.log(headings);
    }


    sidebarNav();
});

