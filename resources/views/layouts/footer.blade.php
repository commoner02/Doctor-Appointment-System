<footer class="bg-white border-t border-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-heartbeat text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-primary-600">DocTime</h3>
                    <p class="text-sm text-gray-500">Your healthcare partner</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">© {{ date('Y') }} DocTime. All rights reserved.</p>
                <div class="mt-1 space-x-4 text-xs text-gray-400">
                    <a href="#" class="hover:text-primary-500">Privacy</a>
                    <a href="#" class="hover:text-primary-500">Terms</a>
                    <a href="#" class="hover:text-primary-500">Support</a>
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