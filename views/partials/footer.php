</main>
    <footer>
        <div class="container">
            <p>
                <a href="index.php?action=acerca-de" style="color: white; text-decoration: underline;">Acerca de la App</a>
            </p>
            <p style="margin-top: 10px;">&copy; 2025 - Duarte Fabricio | Proyecto Final Programación II | UTN FRRe Sede Formosa</p>
        </div>
    </footer>
    <script>
       
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
            });
        }
    </script>
</body>
</html>