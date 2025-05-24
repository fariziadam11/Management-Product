// Dashboard Charts
export const initDashboardCharts = () => {
    const salesChart = initSalesChart();
    const categoryChart = initCategoryChart();

    // Handle responsiveness
    window.addEventListener('resize', () => {
        if (salesChart) salesChart.resize();
        if (categoryChart) categoryChart.resize();
    });
};

const initSalesChart = () => {
    const ctx = document.getElementById('salesChart')?.getContext('2d');
    if (!ctx) return null;

    const gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
    gradientFill.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
    gradientFill.addColorStop(1, 'rgba(59, 130, 246, 0)');

    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.labels,
            datasets: [{
                label: 'Sales',
                data: salesData.values,
                borderColor: '#3b82f6',
                backgroundColor: gradientFill,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: window.innerWidth < 768 ? 4 : 7,
                        font: {
                            size: window.innerWidth < 768 ? 10 : 12
                        }
                    }
                },
                y: {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: value => `$${value}`,
                        font: {
                            size: window.innerWidth < 768 ? 10 : 12
                        }
                    },
                    grid: {
                        color: "rgb(243, 244, 246)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#6b7280",
                    titleMarginBottom: 10,
                    titleColor: '#374151',
                    titleFont: {
                        size: window.innerWidth < 768 ? 12 : 14
                    },
                    bodyFont: {
                        size: window.innerWidth < 768 ? 11 : 13
                    },
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 15,
                    displayColors: false,
                    callbacks: {
                        label: context => {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) {
                                label += `$${context.parsed.y.toFixed(2)}`;
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
};

const initCategoryChart = () => {
    const ctx = document.getElementById('categoryChart')?.getContext('2d');
    if (!ctx) return null;

    return new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: categoryData.labels,
            datasets: [{
                data: categoryData.values,
                backgroundColor: [
                    '#3b82f6', // blue
                    '#10b981', // green
                    '#06b6d4', // cyan
                    '#f59e0b', // yellow
                    '#ef4444', // red
                    '#6b7280'  // gray
                ],
                hoverBackgroundColor: [
                    '#2563eb',
                    '#059669',
                    '#0891b2',
                    '#d97706',
                    '#dc2626',
                    '#4b5563'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#6b7280",
                    titleColor: '#374151',
                    bodyFont: {
                        size: window.innerWidth < 768 ? 11 : 13
                    },
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 15,
                    displayColors: false,
                    callbacks: {
                        label: context => {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value * 100) / total).toFixed(1);
                            return `${label}: ${percentage}%`;
                        }
                    }
                }
            }
        }
    });
};

// Initialize charts when DOM is loaded
document.addEventListener('DOMContentLoaded', initDashboardCharts);
