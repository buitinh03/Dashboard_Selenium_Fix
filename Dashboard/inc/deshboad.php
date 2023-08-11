
<?php include_once('connect.php'); ?>

<?php

$pd = new product();

?>

<?php

// Tổng số lượng sản phẩm
    $chart = $pd->analysischart();
    $test = array();
    $counts = 0;
    while($row = $chart->fetch(PDO::FETCH_ASSOC)){
        $test[$counts]["label"] = "Tổng sản phẩm";
        $test[$counts]["y"] = $row["quantity"];
        $counts += 1;
    }

      // Tổng số lượng bán
  $charproductorder = $pd->charproductorder();
  $result = array();
  $count = 0;
  while($row = $charproductorder->fetch(PDO::FETCH_ASSOC)){
  	$result[$count]["label"] = "Đã bán";
  	$result[$count]["y"] = $row["sale"];
  	$count += 1;
  }

    // Tổng Tiền các sản phẩm đã bán
  $chartSumproductorder = $pd->chartSumproductorder();
  $resultSum = array();
  $countSum = 0;
  while($rowSum = $chartSumproductorder->fetch(PDO::FETCH_ASSOC)){
  	$resultSum[$countSum]["label"] = "Doanh thu";
  	$resultSum[$countSum]["y"] = $rowSum["orderprice"];
  	$countSum += 1;
  }
    ?>
<script>
    window.onload =function(){
   // Tổng số lượng sản phẩm 
var chart1 = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    title: {
        text: "Tổng sản phẩm"
    },
    subtitles: [{
        text: ""
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0\"sản phẩm\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
    }]
});
chart1.render();


// Tổng số lượng sản phẩm đã bán
var chart2 = new CanvasJS.Chart("charproductorder", {
	theme: "light2",
	animationEnabled: true,
	title: {
		text: "Sản phẩm đã bán"
	},
	data: [{
		type: "doughnut",
		indexLabel: "{symbol}  {y}",
		yValueFormatString: "#,##0\" sản phẩm\"",
		showInLegend: true,
		legendText: "{label} : {y}",
		dataPoints: <?php echo json_encode($result, JSON_NUMERIC_CHECK); ?>
	}]
});
chart2.render();

// Tổng tiền số  sản phẩm đã bán
var chart3 = new CanvasJS.Chart("chartSumproductorder", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Daonh thu"
	},
	axisY:{
		includeZero: true
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		indexLabel: "{y}", //Shows y value on all Data Points
		yValueFormatString: "#,##0\"đ\"",
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
		dataPoints: <?php echo json_encode($resultSum, JSON_NUMERIC_CHECK); ?>
	}]
});
chart3.render();
    }
// aler("hello")  
</script>




<! END OF ASIDE>
            <main>
            <h1>BẢNG ĐIỀU KHIỂN</h1>
                
                <div class="date" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                 <h3><span id="rank"></span> - Ngày: <span id="dates"></span><br> Giờ:  <span id="coundtime"></span></h3>
                </div>
            
                <div class="insights">
                    <style>
                        .tongsanpham {
                            transition: 0.5s all ease;
                            cursor: pointer;
                        }
                        .tongsanpham:hover {
                            transform: translateY(-10px);
                        }
                    </style>
                <?php
                        $tongsanpham =  $pd->tongsanpham();
                        if($tongsanpham){
                            while($result = $tongsanpham->fetch(PDO::FETCH_ASSOC)){

                  
                        ?>
                    
                    <div class="sales">
                        <span class="material-icons-sharp">analytics</span>
                        <div hidden id="chartContainer" style="height: 150px; width: 100%;"></div>
                        
                        <div class="tongsanpham"  style="margin-top: 15%; text-align:center;   font-size: 40px;"><?php echo $result['quantity']?><p style="font-size: 20px; color:blue">Sản Phẩm</p></div>
                     
                        
                    </div>
                    <?php
                            }
                        }
                        ?>
                    <!END OF SALES>
                    <div class="expenses">
                        <span class="material-icons-sharp">stacked_line_chart</span>
                        <div id="charproductorder" style="height: 150px; width: 100%;"></div>
                        <!-- <small class="text-muted">24h qua</small> -->
                    </div>
                    <!END OF EXPENSE>
                    <div class="income">
                        <span class="material-icons-sharp">leaderboard</span>
                        <div class="tongsanpham"  style=" text-align:center;   font-size: 20px;"><?php ?><p style="font-size: 20px; color:blue">So sánh</p></div>
                        <div class="middle">
                            <canvas id="myChart"  style="height: 150px; width: 100%;"></canvas>
                        </div>
                      
                    </div>
                    <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                    data: {
                                labels: [],
                                datasets: []
                            },
                            options: {}
                        });

                        function handleClick(event) {
                            var rowData = event.target.parentNode;
                            var cells = rowData.getElementsByTagName('td');

                            var data = [];
                            for (var i = 3; i <cells.length-2; i++) {
                                data.push(parseInt(cells[i].innerText));
                            }

                            var dataset = {
                                // label: 'Dòng ' + (myChart.data.labels.length + 1),
                                label:cells[1].innerText,
                                data: data,
                                backgroundColor: 'blue'
                            };
                            var h=1;
                            var lb=[];
                            for (var i = 3; i <cells.length-2; i++){
                                lb.push("T "+h);
                                h++
                            }
                            
                            myChart.data.labels = lb;
                            myChart.data.datasets = [dataset];
                            myChart.update();
                        }
                    </script>
                    <!END OF INCOME>
                    <!-- <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script> -->
                    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
           


                      
