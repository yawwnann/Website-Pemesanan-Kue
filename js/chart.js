   const months=<?php echo json_encode($months); ?>;
    const incomes=<?php echo json_encode($incomes); ?>;

    const productNames=<?php echo json_encode($productNames); ?>;
    const productQuantities=<?php echo json_encode($productQuantities); ?>;

    const ctxIncome=document.getElementById("incomeChart").getContext("2d");
    const incomeChart=new Chart(ctxIncome,{
        type: "line",
        data: {
            labels: months,
            datasets: [{
                label: "Pemasukan (Rp)",
                data: incomes,
                backgroundColor: "rgba(75, 0, 75, 0.2)",
                borderColor: "rgb(202, 111, 8)",
                borderWidth: 1,
                pointRadius: 5,
            }],
        },
        options: {
            responsive: true,
            layout: {
                padding: {
                    bottom: 20,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return "Rp "+value.toLocaleString();
                        },
                    },
                },
            },
        },
    });

    // Doughnut chart untuk produk paling banyak dipesan
    const ctxProduct=document.getElementById("productChart").getContext("2d");
    const productChart=new Chart(ctxProduct,{
        type: "doughnut",
        data: {
            labels: productNames,
            datasets: [{
                label: "Jumlah Pesanan",
                data: productQuantities,
                backgroundColor: [
                    "rgb(39, 20, 24)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)",
                ],
                borderColor: [
                    "rgb(54, 26, 32)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)",
                ],
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "top",
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label+": "+tooltipItem.raw+" pcs";
                        },
                    },
                },
            },
        },
    });