const ctx = document.getElementById('chartContainer').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['ยอดขาย', 'ผู้ใช้งาน'],
                datasets: [{
                    label: 'ข้อมูล',
                    data: [1200, 2847],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });
