(function ($) {
  google.charts.load("current", { packages: ["corechart", "bar"] });
  google.charts.load("current", { packages: ["line"] });
  google.charts.load("current", { packages: ["corechart"] });
  google.charts.setOnLoadCallback(drawBasic);
  function drawBasic() {
    if ($("#column-chart1").length > 0) {
      var a = google.visualization.arrayToDataTable([
        ["Month", "DELIVRD", "UNDELIV"],
        ["Jan", 80000000, 25000000],
        ["Feb", 90000000, 16000000],
        ["Mar", 70000000, 20000000],
        ["Apr", 80580000, 10000000],
        ["May", 60000000, 10000000],
        ["Jun", 100000000, 10000000],
        ["Jul", 60000000, 10000000],
        ["Aug", 100000000, 22306089],
        ["Sep", 120000000, 20067000],
        ["Oct", 140000000, 47800000],
        ["Nov", 160000000, 50056300],
        ["Dec", 180000000, 39019890],
      ]),
        b = {
          chart: {
            title: "Yearly Performance 2024",
            //subtitle: "Sales, Expenses, and Profit: 2014-2017",
          },
          bars: "vertical",
          vAxis: {
            format: "decimal",
          },
          height: 400,
          width: "100%",
          colors: [
            MofiAdminConfig.primary,
            MofiAdminConfig.secondary,
            "#51bb25",
          ],
        },
        c = new google.charts.Bar(document.getElementById("column-chart1"));
      c.draw(a, google.charts.Bar.convertOptions(b));
    }
   
   
  }
 

  function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn("string", "Task ID");
    data.addColumn("string", "Task Name");
    data.addColumn("string", "Resource");
    data.addColumn("date", "Start Date");
    data.addColumn("date", "End Date");
    data.addColumn("number", "Duration");
    data.addColumn("number", "Percent Complete");
    data.addColumn("string", "Dependencies");

    data.addRows([
      [
        "Research",
        "Find sources",
        null,
        new Date(2015, 0, 1),
        new Date(2015, 0, 5),
        null,
        100,
        null,
      ],
      [
        "Write",
        "Write paper",
        "write",
        null,
        new Date(2015, 0, 9),
        daysToMilliseconds(3),
        25,
        "Research,Outline",
      ],
      [
        "Cite",
        "Create bibliography",
        "write",
        null,
        new Date(2015, 0, 7),
        daysToMilliseconds(1),
        20,
        "Research",
      ],
      [
        "Complete",
        "Hand in paper",
        "complete",
        null,
        new Date(2015, 0, 10),
        daysToMilliseconds(1),
        0,
        "Cite,Write",
      ],
      [
        "Outline",
        "Outline paper",
        "write",
        null,
        new Date(2015, 0, 6),
        daysToMilliseconds(1),
        100,
        "Research",
      ],
    ]);

    var options = {
      height: 275,
      gantt: {
        criticalPathEnabled: false, // Critical path arrows will be the same as other arrows.
        arrow: {
          angle: 100,
          width: 5,
          color: "#51bb25",
          radius: 0,
        },

        palette: [
          {
            color: MofiAdminConfig.primary,
            dark: MofiAdminConfig.secondary,
            light: "#047afb",
          },
        ],
      },
    };
    var chart = new google.visualization.Gantt(
      document.getElementById("gantt_chart")
    );

    chart.draw(data, options);
  }
  // word tree
  google.charts.load("current1", { packages: ["wordtree"] });
  google.charts.setOnLoadCallback(drawChart1);

  function drawChart1() {
    var data = google.visualization.arrayToDataTable([
      ["Phrases"],
      ["cats are better than dogs"],
      ["cats eat kibble"],
      ["cats are better than hamsters"],
      ["cats are awesome"],
      ["cats are people too"],
      ["cats eat mice"],
      ["cats meowing"],
      ["cats in the cradle"],
      ["cats eat mice"],
      ["cats in the cradle lyrics"],
      ["cats eat kibble"],
      ["cats for adoption"],
      ["cats are family"],
      ["cats eat mice"],
      ["cats are better than kittens"],
      ["cats are evil"],
      ["cats are weird"],
      ["cats eat mice"],
    ]);

    var options = {
      wordtree: {
        format: "implicit",
        word: "cats",
      },
    };
    var chart = new google.visualization.WordTree(
      document.getElementById("wordtree_basic")
    );
    chart.draw(data, options);
  }
})(jQuery);
