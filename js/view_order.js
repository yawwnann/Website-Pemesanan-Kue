//  grafik pemasukan per bulan
const ctxIncome = document.getElementById("incomeChart").getContext("2d");
const incomeChart = new Chart(ctxIncome, {
  type: "line",
  data: {
    labels: months,
    datasets: [
      {
        label: "Pemasukan (Rp)",
        data: incomes,
        backgroundColor: "rgba(75, 0, 75, 1)",
        borderColor: "rgb(100, 5, 119)",
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: function (value) {
            return "Rp " + value.toLocaleString();
          },
        },
      },
    },
  },
});

//grafik donat (pie chart) produk
const ctxProduct = document.getElementById("productChart").getContext("2d");
const productChart = new Chart(ctxProduct, {
  type: "doughnut",
  data: {
    labels: productNames,
    datasets: [
      {
        label: "Jumlah Pesanan",
        data: productQuantities,
        backgroundColor: [
          "rgba(255, 99, 132, 1)",
          "rgba(54, 162, 235, 1)",
          "rgba(255, 206, 86, 1)",
          "rgba(75, 192, 192, 1)",
          "rgba(153, 102, 255, 1)",
          "rgba(255, 159, 64, 1)",
        ],
        borderColor: [
          "rgba(255, 99, 132, 1)",
          "rgba(54, 162, 235, 1)",
          "rgba(255, 206, 86, 1)",
          "rgba(75, 192, 192, 1)",
          "rgba(153, 102, 255, 1)",
          "rgba(255, 159, 64, 1)",
        ],
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: "top",
      },
      tooltip: {
        callbacks: {
          label: function (tooltipItem) {
            return tooltipItem.label + ": " + tooltipItem.raw + " pcs";
          },
        },
      },
    },
  },
});
