$(document).ready(function() {
  var korean_total = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var foreigner_total = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var tourist_total = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var china_total = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var japan_total = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var hongkong_total = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var us_total = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var else_total = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

  $.get('/static/jeju/jeju_korean.xml', function(data) {
    $(data).find("Row").each(function() {
      if ($(this).find("구분").text() == "형태별") {
        for (var i = 0; i < 12; i++) {
          if(i < 9)
            var name = "_2017년0" + (i + 1) + "월";
          else
            var name = "_2017년" + (i + 1) + "월";
          korean_total[i] += Number($(this).find(name).text());
          tourist_total[i] += Number($(this).find(name).text());
        }
      }
    })
  });
  $.get('/static/jeju/jeju_foreigner.xml', function(data) {
    $(data).find("Row").each(function() {
      for (var i = 0; i < 12; i++) {
        if(i < 9)
          var name = "_2017년0" + (i + 1) + "월";
        else
          var name = "_2017년" + (i + 1) + "월";
        if ($(this).find("상세").text() == "중국") {
          china_total[i] += Number($(this).find(name).text());
        }else if($(this).find("상세").text() == "일본"){
          japan_total[i] += Number($(this).find(name).text());
        }else if ($(this).find("상세").text() == "홍콩") {
          hongkong_total[i] += Number($(this).find(name).text());
        }else if ($(this).find("상세").text() == "미국") {
          us_total[i] += Number($(this).find(name).text());
        }else{
          else_total[i] += Number($(this).find(name).text());
        }
          foreigner_total[i] += Number($(this).find(name).text());
          tourist_total[i] += Number($(this).find(name).text());
        }
      })
    });

    setTimeout(function() { // Code here
    var ctxL = $("#lineChart")[0].getContext("2d");
    var myLineChart = new Chart(ctxL, {
        type: 'line',
        data: {
            labels: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
            datasets: [{
              label: "총 관광객 수",
              data: tourist_total,
              backgroundColor: [
                  'rgba(255, 206, 86, 0.2)',
              ],
              borderColor: [
                  'rgba(200, 99, 132, .7)',
              ],
              borderWidth: 2
            },
            {
              label: "한국인",
              data: korean_total,
              backgroundColor: [
                  'rgba(105, 0, 132, .2)',
              ],
              borderColor: [
                  'rgba(153, 102, 255, 1)',
              ],
              borderWidth: 2
            },
            {
              label: "외국인",
              data: foreigner_total,
              backgroundColor: [
                  'rgba(0, 10, 130, .7)',
              ],
              borderColor: [
                  'rgba(0, 137, 132, .2)',
              ],
              borderWidth: 2
          }]
        },
        options: {
            responsive: true
        }
    });
  }, 100);
  //pie
  setTimeout(function() {
    var ctxP = $("#pieChart")[0].getContext('2d');
    var today = new Date();
    var k = today.getMonth() + 1;
    var piedata = [china_total[k], hongkong_total[k], japan_total[k], us_total[k],else_total[k]];
    var myPieChart = new Chart(ctxP, {
      type: 'pie',
      data: {
        labels: ["중국", "홍콩", "일본", "미국", "그 외"],
        datasets: [{
          data: piedata,
          backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
          hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
        }]
      },
      options: {
        responsive: true
      }
    });
  }, 100);

})
