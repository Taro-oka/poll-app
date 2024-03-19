poll_chart();

function poll_chart() {
  const chart = document.querySelector("#chart");

  if (!chart) {
    return;
  }

  const ctx = chart.getContext("2d");

  // 学習用：htmlの、data-〇〇、という属性を任意で設定することができ、その値を取得するには、↓のように、（DOM）.dataset.〇〇、という風に、取得する！！
  const likes = Number(chart.dataset.likes);
  const dislikes = Number(chart.dataset.dislikes);

  let data = [];

  if (likes === 0 && dislikes === 0) {
    data = {
      labels: ["まだ投票がありません。"],
      datasets: [
        {
          data: [1],
          backgroundColor: ["#9ca3af"],
        },
      ],
    };
  } else {
    data = {
      labels: ["賛成", "反対"],
      datasets: [
        {
          data: [likes, dislikes],
          backgroundColor: ["#34d399", "#f87171"],
        },
      ],
    };
  }

  new Chart(ctx, {
    type: "pie",
    data,
    options: {
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            font: { size: 24 },
          },
        },
      },
    },
  });
}
