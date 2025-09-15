<x-layout.guest.app title="" activeMenu="landing" :withError="false">
    <div class="main-container">
        <img src="{{ asset('assets/img/front-pages/hero-bg.png') }}" class="main-bg">

        <x-layout.guest.navbar />

        <div class="content-wrapper">
            <div class="container mt-4 text-center copyright">
                <p>
                    ©
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    <a href="https://prabubimatech.com" target="_blank" class="footer-link">Team Developer
                        PrabubimaTech</a>
                </p>
            </div>
            </footer>
        </div>
    </div>
</x-layout.guest.app>
