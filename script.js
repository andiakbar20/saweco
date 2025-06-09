// Toggle class acttive Hamburger Menu
const navbarNav = document.querySelector(".navbar-nav");
//ketika humberger-menu di klik
document.querySelector("#hamburger-menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

// Klik diluar elemen
const hm = document.querySelector("#hamburger-menu");

document.addEventListener("click", function (e) {
  if (!hm.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});

var swiper = new Swiper(".row", {
  spaceBetween: 10,
  centeredSlide: true,
  autoplay: {
    delay: 9500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    640: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 3,
    },
  },
});

// Contact Form WhatsApp Integration
document
  .querySelector(".contact form")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const subject = document.getElementById("subject").value;
    const message = document.getElementById("message").value;

    if (name && email && subject && message) {
      const whatsappMessage = `Halo SAWECO!%0A%0ANama: ${name}%0AEmail: ${email}%0ASubjek: ${subject}%0A%0APesan:%0A${message}`;
      const whatsappNumber = "6281348201731";
      const whatsappURL = `https://wa.me/${whatsappNumber}?text=${whatsappMessage}`;

      window.open(whatsappURL, "_blank");
    } else {
      alert("Mohon isi semua field yang diperlukan");
    }
  });

// Form submission handler
function sendMassage() {
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const subject = document.getElementById("subject").value;
  const message = document.getElementById("message").value;

  const url =
    "https://api.whatsapp.com/send?phone=6281348201731&text=Halo%20admin%20Saweco!%0ASaya%20*" +
    name +
    "%0AEmail%20" +
    email +
    "%0A%0A" +
    subject +
    "%0A%0A" +
    message +
    "*";
  window.open(url);
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute("href"));
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    }
  });
});

// Add animation on scroll
const observerOptions = {
  threshold: 0.1,
  rootMargin: "0px 0px -50px 0px",
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.style.animationPlayState = "running";
    }
  });
}, observerOptions);

// Observe elements with animations
document
  .querySelectorAll(".about-card, .product-card, .contact-form, .contact-map")
  .forEach((el) => {
    observer.observe(el);
  });