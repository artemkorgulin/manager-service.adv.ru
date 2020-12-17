<?php 

$config = [
    'host'       => 'localhost',
    'name'       => 'lander',
    'user'       => 'lander_user',
    'password'   => 'PRp26V'
];

try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 

    $stmt_orders = $pdo->query("SELECT id,`data` FROM lander.db_land  order by id asc limit 1000000")->fetchAll();
    foreach ($stmt_orders as $row) {
        $date = date('Y-m-d',strtotime($row['data']));
        if (!isset($dateArr[$date]))
            $dateArr[$date] = [];
        array_push($dateArr[$date],$row['id']);
    }
    foreach ($dateArr as $row => $val) {
        
        $parent = "";
        for ($i=0;$i<count($val);$i++) {
            if ((count($val)-1) == $i) {
                $parent .= $val[$i];
            } else {
                $parent .= $val[$i].",";
            }
        }
        $stmt_ordersfull = $pdo->query("SELECT count(*) as cnt FROM lander.db_land where id in (".$parent.")");
        $res_stmt_ordersfull = $stmt_ordersfull->fetch(PDO::FETCH_ASSOC);
        $dateArr[$row] = $res_stmt_ordersfull['cnt'];


    }

} catch(PDOException $e) {}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<script src="https://d3js.org/d3.v3.min.js"> </script>
<style>
.axis path, .axis line {
    fill: none;
    stroke: #333;
}
.axis .grid-line {
    stroke: #000;
    stroke-opacity: 0.2;
}
.axis text {
    font: 10px Verdana;
}
</style>
<body>

<script type="text/javascript">
var height = 700, 
    width = document.body.offsetWidth, 
    margin=60,
    rawData = [],
    data=[];
    var dataArr = <?php echo json_encode($dateArr);?>;
    rawData = [];
    var stx = 0;
    var max = 0;
    for(var i in dataArr ){

        if(!dataArr.hasOwnProperty(i)) continue;
        if (parseInt(dataArr[i]) > max) max = parseInt(dataArr[i]);
        rawData.push({x: stx+=1, y: dataArr[i], date: i});

    }
// создание объекта svg
var svg = d3.select("body").append("svg")
        .attr("class", "axis")
        .attr("width", width)
        .attr("height", height);

// длина оси X= ширина контейнера svg - отступ слева и справа
var xAxisLength = width - 2 * margin;     
 
// длина оси Y = высота контейнера svg - отступ сверху и снизу
var yAxisLength = height - 2 * margin;
   var startDate = rawData[0].date.split('-');
   startDate[1] -= 1;

   var endDate = rawData[rawData.length-1].date.split('-');
   endDate[1] -= 1;
// функция интерполяции значений на ось Х  
var scaleX = d3.time.scale()
            .domain([new Date(...startDate), new Date( ...endDate )])
            .range([0, xAxisLength]);
// функция интерполяции значений на ось Y
var scaleY = d3.scale.linear()
            .domain([max, 0])
            .range([0, yAxisLength]);
// масштабирование реальных данных в данные для нашей координатной системы
for(i=0; i<rawData.length; i++)
    data.push({ y: scaleY(rawData[i].y) + margin, date: rawData[i].date});
            
// создаем ось X   
var xAxis = d3.svg.axis()
             .scale(scaleX)
             .orient("bottom")
             .ticks(rawData.length)
             .tickFormat(d3.time.format('%d.%m.%y'));
// создаем ось Y             
var yAxis = d3.svg.axis()
             .scale(scaleY)
             .orient("left");
             
 // отрисовка оси Х             
svg.append("g")       
     .attr("class", "x-axis")
     .attr("transform",  // сдвиг оси вниз и вправо
         "translate(" + margin + "," + (height - margin) + ")")
    .call(xAxis)
      .selectAll("text")
          .attr("x", 30)
          .attr("y", -5)
       .attr("transform", "rotate(90)");

 // отрисовка оси Y 
svg.append("g")       
    .attr("class", "y-axis")
    .attr("transform", // сдвиг оси вниз и вправо на margin
            "translate(" + margin + "," + margin + ")")
    .call(yAxis);

// создаем набор вертикальных линий для сетки   
d3.selectAll("g.x-axis g.tick")
    .append("line")
    .classed("grid-line", true)
    .attr("x1", 0)
    .attr("y1", 0)
    .attr("x2", 0)
    .attr("y2", - (yAxisLength));
    
// рисуем горизонтальные линии координатной сетки
d3.selectAll("g.y-axis g.tick")
    .append("line")
    .classed("grid-line", true)
    .attr("x1", 0)
    .attr("y1", 0)
    .attr("x2", xAxisLength)
    .attr("y2", 0);

    svg.selectAll(".dot")
    .data(rawData)
    .enter().append("circle")
    .attr("class", "dot")
    .attr("r", 3.5)
    .attr("cx", function(d) { 
        var ddd = d.date.split('-');
        ddd[1] -= 1;
        return scaleX(new Date(...ddd))+margin;
    })
    .attr("cy", function(d) { return scaleY(d.y)+margin; })



    svg.selectAll(".dotText")
  .data(rawData)
 .enter().append("text")
  .attr("class", "dotText")
  .attr("x", function(d) {        var ddd = d.date.split('-');
        ddd[1] -= 1;
        return scaleX(new Date(...ddd))+margin; })
  .attr("y", function(d) { return scaleY(d.y)+margin; })
   .attr("dx", "-1.2em")
  .attr("dy", "-1.2em")
  .text(function(d){

        return Math.ceil(d.y);

    });

// функция, создающая по массиву точек линии
var line = d3.svg.line()
            .x(function(d){
                var ddd = d.date.split('-');
                ddd[1] -= 1;
                return scaleX(new Date(...ddd))+margin;
            })
            .y(function(d){return d.y;});
// добавляем путь
svg.append("g").append("path")
.attr("d", line(data))
.style("stroke", "steelblue")
.style("stroke-width", 2);
</script>
</body>
</html>