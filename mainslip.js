$(document).ready(function() {
    // Ensure jQuery is available
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded');
        $('#list').html('<p>เกิดข้อผิดพลาด: ไม่สามารถโหลด jQuery ได้</p>');
        return;
    }
    if (orderData.items && orderData.items.length > 0) {
        var html = '';
        var sumprice = parseFloat(orderData.total_amount || 0);

        // Add Date and Time
        html += `<div class="text-center mb-3"><p>วันที่: ${orderDate.split(' ')[0]}</p><p>เวลา: ${orderDate.split(' ')[1]}</p></div><hr>`;

        // Create HTML for Food List
        orderData.items.forEach(item => {
            var itemTotal = parseFloat(item.price) * item.count;
            if (isNaN(itemTotal)) itemTotal = 0; // Fallback for invalid data
            html += `
                <div class="list-items">
                    <p>[x${item.count || 1}] ${item.name || 'Unnamed Item'}</p>
                    <p>${numberWithCommas(itemTotal)} THB</p>
                </div>
            `;
        });

        // Add total
        html += `
            <div class="list-items list-summary">
                <p>รวมราคา</p>
                <p>${numberWithCommas(sumprice)} THB</p>
            </div>
        `;

        $("#list").html(html);
    } else {
        $('#list').html('<p>ไม่พบรายการอาหารที่สั่ง</p>');
    }

    // Attach print event listener
    $("#printReceipt").on('click', function() {
        printReceipt();
    });
});

function numberWithCommas(x) {
    if (isNaN(parseFloat(x))) return '0.00';
    x = parseFloat(x).toFixed(2);
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function printReceipt() {
    // Create a new window or document fragment for printing
    var printWindow = window.open('', '', 'height=600,width=800');
    var printContent = `
        <!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <title>ใบเสร็จ</title>
            <style>
                body { font-family: 'IBM Plex Sans Thai', sans-serif; padding: 20px; }
                .text-center { text-align: center; }
                .list-items { display: flex; justify-content: space-between; margin-bottom: 8px; border-bottom: 1px dashed #ccc; padding-bottom: 8px; }
                .list-summary { font-weight: bold; border-top: 2px solid #000; padding-top: 8px; }
                hr { border: 0; border-top: 1px solid #ccc; margin: 10px 0; }
            </style>
        </head>
        <body>
            <h2 class="text-center">PURE888 FOOD</h2>
            <div class="text-center mb-3">
                <p>วันที่: ${orderDate.split(' ')[0]}</p>
                <p>เวลา: ${orderDate.split(' ')[1]}</p>
            </div>
            <hr>
            <div id="print-list">${document.getElementById('list').innerHTML}</div>
        </body>
        </html>
    `;

    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();

    // Clean up after printing
    printWindow.onafterprint = function() {
        printWindow.close();
    };
}