
const ctx = document.getElementById('myChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000],
        datasets: [
            {
                label: 'Dữ liệu 1',
                data: [500, 700, 1500, 5000, 6000, 4000, 2500, 1000, 300, 100],
                borderColor: 'blue',
                backgroundColor: 'rgba(0, 0, 255, 0.1)',
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: 'blue'
            },
            {
                label: 'Dữ liệu 2',
                data: [1000, 1200, 1300, 1400, 1600, 3000, 4000, 5000, 6000, 7000],
                borderColor: 'green',
                backgroundColor: 'rgba(0, 128, 0, 0.1)',
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: 'green'
            },
            {
                label: 'Dữ liệu 3',
                data: [800, 1000, 1100, 1100, 1100, 1200, 1500, 3000, 7500, 2500],
                borderColor: 'red',
                backgroundColor: 'rgba(255, 0, 0, 0.1)',
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: 'red'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: { size: 14 }
                }
            },
            tooltip: {
                backgroundColor: '#333',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderWidth: 1,
                borderColor: '#ddd'
            }
        },
        scales: {
            x: {
                grid: { display: false }
            },
            y: {
                beginAtZero: true,
                grid: { color: '#ddd' }
            }
        }
    }
});
