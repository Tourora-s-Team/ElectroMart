
let revenueChart;

// Initialize chart when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeChart();
});

function initializeChart() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const year = document.getElementById('year').value;
    
    // Get chart data via AJAX
    fetch(`?admin/financial/chart-data&year=${year}`)
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => `Tháng ${item.Month}/${item.Year}`);
            const revenues = data.map(item => parseFloat(item.TotalRevenue));
            
            if (revenueChart) {
                revenueChart.destroy();
            }
            
            revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: revenues,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN').format(value) + ' VNĐ';
                                }
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 8
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error loading chart data:', error);
        });
}

function refreshChart() {
    initializeChart();
}

// Auto refresh chart when year changes
document.getElementById('year').addEventListener('change', function() {
    setTimeout(refreshChart, 100);
});
