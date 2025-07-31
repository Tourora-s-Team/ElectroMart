</main>
</div>

<!-- Scripts -->
<script src="/public/js/main.js"></script>
<script>
    // Initialize page-specific functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-update timestamps
        updateTimestamps();

        // Initialize tooltips
        initializeTooltips();

        // Set up real-time updates (if needed)
        if (typeof initializeRealTimeUpdates === 'function') {
            initializeRealTimeUpdates();
        }
    });

    function updateTimestamps() {
        const timestamps = document.querySelectorAll('.timestamp');
        timestamps.forEach(timestamp => {
            const date = new Date(timestamp.dataset.date);
            timestamp.textContent = formatDate(date);
        });
    }

    function formatDate(date) {
        return new Intl.DateTimeFormat('vi-VN', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        }).format(date);
    }

    function initializeTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', showTooltip);
            element.addEventListener('mouseleave', hideTooltip);
        });
    }

    function showTooltip(event) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = event.target.dataset.tooltip;
        document.body.appendChild(tooltip);

        const rect = event.target.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
    }

    function hideTooltip() {
        const tooltip = document.querySelector('.tooltip');
        if (tooltip) {
            tooltip.remove();
        }
    }
</script>
</body>

</html>