<footer class="bg-white border-top mt-4">
    <div class="container-fluid px-4">
        <div class="row py-4">
            <!-- Brand Section -->
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="d-flex align-items-center mb-2">
                    <div class="footer-logo me-2">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h6 class="text-primary fw-bold mb-0">DocTime</h6>
                </div>
                <p class="text-muted mb-0 small">Your trusted healthcare partner</p>
            </div>

            <!-- Copyright -->
            <div class="col-md-6 text-md-end">
                <p class="text-muted mb-0 small">© {{ date('Y') }} DocTime. All rights reserved.</p>
                <div class="mt-1">
                    <a href="#" class="text-muted text-decoration-none small me-3">Privacy</a>
                    <a href="#" class="text-muted text-decoration-none small me-3">Terms</a>
                    <a href="#" class="text-muted text-decoration-none small">Support</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-logo {
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    footer a:hover {
        color: #2563eb !important;
    }
</style>