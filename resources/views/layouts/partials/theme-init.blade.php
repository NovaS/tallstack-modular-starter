<script>
    (function () {
        var resolveMode = function () {
            try {
                var stored = localStorage.getItem('dark-theme');
                if (stored === 'true' || stored === 'dark') {
                    return 'dark';
                }
                if (stored === 'system') {
                    return 'system';
                }
                if (stored === 'false' || stored === 'light') {
                    return 'light';
                }
            } catch (e) {}

            return 'light';
        };

        var applyTheme = function () {
            var mode = resolveMode();
            var isDark = mode === 'dark' || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', isDark);

            if (window.Alpine && typeof window.Alpine.$data === 'function') {
                try {
                    var rootData = window.Alpine.$data(document.documentElement);
                    if (rootData && 'mode' in rootData && rootData.mode !== mode) {
                        rootData.mode = mode;
                    }
                } catch (e) {}
            }
        };

        applyTheme();

        if (!window.__tsuiThemeSyncBound) {
            window.__tsuiThemeSyncBound = true;
            document.addEventListener('livewire:navigated', applyTheme);
            window.addEventListener('pageshow', function (event) {
                if (event.persisted) {
                    applyTheme();
                }
            });
        }
    })();
</script>
<style>
    [x-cloak] { display: none !important; }
    html { color-scheme: light; background-color: #f8fafc; }
    html.dark { color-scheme: dark; background-color: #0f172a; }
</style>
