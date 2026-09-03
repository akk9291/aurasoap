/*
   Aura Soaps - Main JavaScript
   Integrates Leaf Particles, GSAP, AOS, Swiper, Counter Animations & Form Handlers
*/

document.addEventListener('DOMContentLoaded', () => {
  // 1. Initialize AOS (Animate On Scroll)
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 800,
      easing: 'ease-out-cubic',
      once: true,
      offset: 60
    });
  }

  // 1b. Initialize Bootstrap Tooltips
  if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
  }

  // 2. Sticky Header Handler
  const navbar = document.getElementById('mainNavbar');
  const handleScroll = () => {
    if (window.scrollY > 40) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  };
  window.addEventListener('scroll', handleScroll);
  handleScroll();

  // 3. Leaf Particles Canvas Animation (Hero Background)
  initLeafParticles();

  // 4. GSAP Micro-Animations & Parallax
  initGsapAnimations();

  // 5. Swiper Testimonials Slider
  if (typeof Swiper !== 'undefined') {
    new Swiper('.testimonials-swiper', {
      slidesPerView: 1,
      spaceBetween: 30,
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      breakpoints: {
        768: { slidesPerView: 2 },
        1200: { slidesPerView: 3 }
      }
    });
  }

  // 6. Number Counter Observer
  initCounterObserver();

  // 7. Product Category Filtering
  initProductFilter();

  // 8. Dynamic Modal Handlers (Products & Blog)
  initModalHandlers();

  // 9. Interactive Form Submissions & Toast
  initFormHandlers();
});

/* Leaf Particle Canvas System */
function initLeafParticles() {
  const canvas = document.getElementById('leafCanvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width = canvas.width = window.innerWidth;
  let height = canvas.height = window.innerHeight;

  window.addEventListener('resize', () => {
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
  });

  const leafColors = ['#0B5E4D', '#3C8D40', '#27C4CC', '#A8EEF0'];
  const particleCount = window.innerWidth < 768 ? 15 : 30;
  const particles = [];

  class LeafParticle {
    constructor() {
      this.reset();
    }

    reset() {
      this.x = Math.random() * width;
      this.y = -20 - Math.random() * height * 0.5;
      this.size = 8 + Math.random() * 14;
      this.speedY = 0.5 + Math.random() * 1.2;
      this.speedX = -0.5 + Math.random() * 1.0;
      this.rotation = Math.random() * Math.PI * 2;
      this.rotSpeed = (Math.random() - 0.5) * 0.02;
      this.color = leafColors[Math.floor(Math.random() * leafColors.length)];
      this.opacity = 0.2 + Math.random() * 0.4;
    }

    update() {
      this.y += this.speedY;
      this.x += Math.sin(this.y * 0.01) + this.speedX;
      this.rotation += this.rotSpeed;

      if (this.y > height + 20 || this.x < -20 || this.x > width + 20) {
        this.reset();
      }
    }

    draw() {
      ctx.save();
      ctx.translate(this.x, this.y);
      ctx.rotate(this.rotation);
      ctx.globalAlpha = this.opacity;
      ctx.fillStyle = this.color;

      // Draw leaf shape path
      ctx.beginPath();
      ctx.moveTo(0, -this.size);
      ctx.quadraticCurveTo(this.size * 0.8, 0, 0, this.size);
      ctx.quadraticCurveTo(-this.size * 0.8, 0, 0, -this.size);
      ctx.fill();

      // Stem line
      ctx.strokeStyle = 'rgba(255,255,255,0.4)';
      ctx.lineWidth = 1;
      ctx.beginPath();
      ctx.moveTo(0, -this.size * 0.8);
      ctx.lineTo(0, this.size * 0.8);
      ctx.stroke();

      ctx.restore();
    }
  }

  for (let i = 0; i < particleCount; i++) {
    particles.push(new LeafParticle());
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);
    particles.forEach(p => {
      p.update();
      p.draw();
    });
    requestAnimationFrame(animate);
  }

  animate();
}

/* GSAP Animations */
function initGsapAnimations() {
  if (typeof gsap === 'undefined') return;

  // Hero Title & Subtitle Entrance
  gsap.from('.hero-badge-wrap', { opacity: 0, y: 30, duration: 1, delay: 0.2 });
  gsap.from('.hero-title', { opacity: 0, y: 40, duration: 1.2, delay: 0.4 });
  gsap.from('.hero-desc', { opacity: 0, y: 30, duration: 1, delay: 0.6 });
  gsap.from('.hero-btns', { opacity: 0, y: 20, duration: 1, delay: 0.8 });
  gsap.from('.hero-img-main', { opacity: 0, scale: 0.92, duration: 1.4, delay: 0.5 });

  // Floating hover tilt
  const heroImg = document.querySelector('.hero-img-main');
  if (heroImg) {
    window.addEventListener('mousemove', (e) => {
      const { clientX, clientY } = e;
      const xPos = (clientX / window.innerWidth - 0.5) * 15;
      const yPos = (clientY / window.innerHeight - 0.5) * 15;
      gsap.to(heroImg, { rotationY: xPos, rotationX: -yPos, duration: 1, ease: 'power1.out' });
    });
  }
}

/* Counter Observer */
function initCounterObserver() {
  const counterElements = document.querySelectorAll('.counter-num');
  if (!counterElements.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const target = entry.target;
        const countTo = parseInt(target.getAttribute('data-count'), 10);
        if (isNaN(countTo)) {
          observer.unobserve(target);
          return;
        }
        const suffix = target.getAttribute('data-suffix') || '';
        let count = 0;
        const step = Math.ceil(countTo / 60);

        const timer = setInterval(() => {
          count += step;
          if (count >= countTo) {
            target.innerText = countTo + suffix;
            clearInterval(timer);
          } else {
            target.innerText = count + suffix;
          }
        }, 30);

        observer.unobserve(target);
      }
    });
  }, { threshold: 0.5 });

  counterElements.forEach(el => observer.observe(el));
}

/* Product Filter */
function initProductFilter() {
  const filterBtns = document.querySelectorAll('.btn-filter');
  const productItems = document.querySelectorAll('.product-grid-item');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.getAttribute('data-filter');

      productItems.forEach(item => {
        const category = item.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          item.style.display = 'block';
          item.style.opacity = '1';
        } else {
          item.style.opacity = '0';
          setTimeout(() => { item.style.display = 'none'; }, 200);
        }
      });
    });
  });
}

/* Dynamic Product & Blog Modals */
const productData = {
  beauty: {
    title: 'Rose & Wildflower Honey Beauty Bar',
    category: 'Beauty Soap',
    image: 'assets/images/beauty_soap.jpg',
    desc: 'An exquisite luxury beauty bar crafted with steam-distilled Damask rose extract and raw organic wildflower honey. Hydrates deeply while restoring skin elastic glow and natural moisture balance.',
    benefits: ['Softens and refines skin texture', 'Natural floral aromatherapy', 'Rich in antioxidants & vitamins C + E', 'Deep non-stripping hydration'],
    ingredients: ['Organic Coconut Oil', 'Olive Oil', 'Damask Rose Petal Distillate', 'Wildflower Honey', 'French Pink Clay', 'Shea Butter', 'Vitamin E']
  },
  herbal: {
    title: 'Green Tea & Mint Botanical Bar',
    category: 'Herbal Soap',
    image: 'assets/images/herbal_soap.jpg',
    desc: 'Revitalizing botanical bar enriched with matcha green tea antioxidants and crisp crushed spearmint leaves. Gently exfoliates and purifies pores for a refreshed skin feel.',
    benefits: ['Soothes irritated or acne-prone skin', 'Antioxidant skin detox', 'Refreshing cooling mint sensation', 'Balancing oil control'],
    ingredients: ['Matcha Green Tea Extract', 'Spearmint Essential Oil', 'Eucalyptus Leaf Oil', 'Organic Olive Oil', 'Jojoba Oil', 'Aloe Leaf Juice']
  },
  moisturizing: {
    title: 'Shea Butter & Oat Milk Nourishing Bar',
    category: 'Moisturizing Soap',
    image: 'assets/images/moisturizing_soap.jpg',
    desc: 'Ultra-creamy moisturizing bar combining unrefined Ghanaian shea butter and colloidal oat milk. Provides intensive replenishment for dry, sensitive, or weathered skin.',
    benefits: ['Locks in 24-hour skin hydration', 'Calms redness and dryness', 'Gentle lipid barrier repair', 'Silky rich foaming lather'],
    ingredients: ['Raw Unrefined Shea Butter', 'Colloidal Oat Milk', 'Sweet Almond Oil', 'Coconut Butter', 'Plant Glycerin', 'Vanilla Extract']
  },
  baby: {
    title: 'Gentle Chamomile & Avocado Baby Bar',
    category: 'Baby Soap',
    image: 'assets/images/baby_soap.jpg',
    desc: 'Mild, tear-free formulation specifically designed for delicate baby skin. Contains organic chamomile inflorescence and pure cold-pressed avocado oil.',
    benefits: ['Hypoallergenic & pediatrician tested', 'No artificial fragrance or dyes', 'Soothes diaper discomfort', 'Extra mild pH balance'],
    ingredients: ['Organic Chamomile Flower Oil', 'Cold-pressed Avocado Oil', 'Calendula Extract', 'Sweet Almond Oil', 'Purified Water']
  },
  medicinal: {
    title: 'Charcoal & Tea Tree Purifying Bar',
    category: 'Medicinal Soap',
    image: 'assets/images/medicinal_soap.jpg',
    desc: 'Therapeutic clarifying soap formulated with activated bamboo charcoal and pure Australian tea tree oil to draw out impurities and combat blemishes.',
    benefits: ['Deep pore detoxing', 'Antimicrobial tea tree action', 'Reduces excess sebum buildup', 'Protects against environmental pollutants'],
    ingredients: ['Activated Bamboo Charcoal', 'Australian Tea Tree Essential Oil', 'Neem Seed Oil', 'Organic Virgin Coconut Oil', 'Castor Oil']
  },
  luxury: {
    title: 'Golden Argan & Saffron Luxury Bar',
    category: 'Luxury Collection',
    image: 'assets/images/luxury_collection_soap.jpg',
    desc: 'Our flagship artisanal luxury bar infused with rare Moroccan golden argan oil, precious saffron threads, and subtle botanical radiance shimmers.',
    benefits: ['Ultimate luxury skin indulgence', 'Promotes luminous radiant complexion', 'Delicate natural golden aura fragrance', 'Deeply nourishing anti-aging lipids'],
    ingredients: ['100% Pure Moroccan Argan Oil', 'Organic Saffron Extract', 'Rosehip Seed Oil', 'Golden Mica (Ethical)', 'Essential Oils Blend']
  }
};

const blogData = {
  1: {
    title: 'The Art of Handcrafted Soap: Why Cold Process Matters',
    category: 'Skincare Guide',
    date: 'August 02, 2026',
    desc: 'Cold process soap making preserves the natural glycerin and vital botanical nutrients often destroyed in high-heat commercial manufacturing. Discover how slow-cure soap crafting transforms everyday bathing into a nourishing ritual.'
  },
  2: {
    title: 'Top 5 Botanical Oils for Radiant Natural Skin',
    category: 'Ingredients Focus',
    date: 'July 28, 2026',
    desc: 'From golden Moroccan argan to cold-pressed avocado oil, natural plant lipids provide bio-compatible fatty acids that reinforce your skin protective moisture barrier.'
  },
  3: {
    title: 'Sustainable Packaging: Our Zero-Plastic Commitment',
    category: 'Eco Living',
    date: 'July 15, 2026',
    desc: 'Learn how Aura Soaps utilizes 100% biodegradable FSC certified paper wrap and plant-based soy inks to protect our planet while delivering luxury skincare.'
  }
};

function initModalHandlers() {
  const productModalEl = document.getElementById('productDetailModal');
  if (productModalEl) {
    const productModal = new bootstrap.Modal(productModalEl);
    document.querySelectorAll('.btn-view-product').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const key = btn.getAttribute('data-key');
        const data = productData[key];
        if (!data) return;

        document.getElementById('modalProdTitle').innerText = data.title;
        document.getElementById('modalProdCategory').innerText = data.category;
        document.getElementById('modalProdImg').src = data.image;
        document.getElementById('modalProdDesc').innerText = data.desc;

        const benefitsList = document.getElementById('modalProdBenefits');
        benefitsList.innerHTML = data.benefits.map(b => `<li><i class="fas fa-check-circle text-aqua me-2"></i>${b}</li>`).join('');

        const ingredientsList = document.getElementById('modalProdIngredients');
        ingredientsList.innerHTML = data.ingredients.map(i => `<span class="badge bg-section text-primary-green p-2 border me-1 mb-1">${i}</span>`).join('');

        productModal.show();
      });
    });
  }

  const blogModalEl = document.getElementById('blogDetailModal');
  if (blogModalEl) {
    const blogModal = new bootstrap.Modal(blogModalEl);
    document.querySelectorAll('.btn-read-blog').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const key = btn.getAttribute('data-key');
        const data = blogData[key];
        if (!data) return;

        document.getElementById('modalBlogTitle').innerText = data.title;
        document.getElementById('modalBlogCategory').innerText = data.category + ' • ' + data.date;
        document.getElementById('modalBlogDesc').innerText = data.desc;

        blogModal.show();
      });
    });
  }
}

/* Form Handlers & Toast Notification */
function initFormHandlers() {
  const distributorForm = document.getElementById('distributorForm');
  if (distributorForm) {
    distributorForm.addEventListener('submit', (e) => {
      e.preventDefault();
      distributorForm.reset();
      showToast('Distributor Application Received! Our global partnerships team will reach out within 24 hours.');
    });
  }

  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      contactForm.reset();
      showToast('Thank you for contacting Aura Soaps! We have received your message.');
    });
  }

  const newsletterForm = document.getElementById('newsletterForm');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', (e) => {
      e.preventDefault();
      newsletterForm.reset();
      showToast('Subscribed! Welcome to the Aura Soaps botanical newsletter.');
    });
  }
}

function showToast(message) {
  let toast = document.getElementById('auraToast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'auraToast';
    toast.className = 'toast-aura';
    toast.innerHTML = `<i class="fas fa-leaf text-light-aqua fs-5"></i><span id="toastMsg"></span>`;
    document.body.appendChild(toast);
  }
  document.getElementById('toastMsg').innerText = message;
  toast.classList.add('show');

  setTimeout(() => {
    toast.classList.remove('show');
  }, 4500);
}
