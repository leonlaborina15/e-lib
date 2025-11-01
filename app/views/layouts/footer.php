</main>
    </div>
</div>

<script src="<?= BASE_URL ?>/js/bootstrap.bundle.js"></script>

<script>
    function toggleTheme() {
        const body = document.body;
        const icon = document.getElementById('themeIcon');

        if (body.classList.contains('dark-theme')) {
            body.classList.remove('dark-theme');
            icon.classList.remove('bi-sun');
            icon.classList.add('bi-moon');
            localStorage.setItem('theme', 'light');
        } else {
            body.classList.add('dark-theme');
            icon.classList.remove('bi-moon');
            icon.classList.add('bi-sun');
            localStorage.setItem('theme', 'dark');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme');
        const icon = document.getElementById('themeIcon');

        if (savedTheme === 'dark') {
            document.body.classList.add('dark-theme');
            if (icon) {
                icon.classList.remove('bi-moon');
                icon.classList.add('bi-sun');
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });

    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltips].map(el => new bootstrap.Tooltip(el));

    const popovers = document.querySelectorAll('[data-bs-toggle="popover"]');
    [...popovers].map(el => new bootstrap.Popover(el));

    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
</script>

<button id="backToTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
    <i class="bi bi-arrow-up"></i>
</button>

</body>
</html>