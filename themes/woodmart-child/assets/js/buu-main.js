window.addEventListener('load', function () {


    function catSwiper() {
        const catPageSwiper = document.getElementById('cat-page-swiper');
        const swiper = new Swiper(catPageSwiper, {
            // Default parameters
            slidesPerView: 2,
            spaceBetween: 10,
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                    slidesPerView: 1.5
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 4,
                    spaceBetween: 40
                }
            }
        });
        swiper
    }
    catSwiper()

    function homeCatSlider(id) {
        const homePageCatLatestOne = document.getElementById('hp-cat-latest-' + id);
        const swiper = new Swiper(homePageCatLatestOne, {
            // Default parameters
            slidesPerView: 1.5,
            spaceBetween: 10,
            // Responsive breakpoints
            breakpoints: {
                765: {
                    enabled: false,
                },
            }
        });

        console.log(homePageCatLatestOne);
    }

    homeCatSlider(512)
    homeCatSlider(520)
    homeCatSlider(513)
    homeCatSlider(515)

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


})
