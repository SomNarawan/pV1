$( document ).ready(function() {

    function getChartJs2(type) {
        var config = null;
        
        if (type === 'line') {
            config = {
                type: 'line',
                data: {
                    labels: ["1", "2", "3", "4", "5", "6", "7"],
                    datasets: [{
                        label: "y = 2 * อายุ",
                        data: [1, 3, 5, 7, 9, 11, 13],
                        borderColor: 'rgba(0, 188, 212, 0.75)',
                        backgroundColor: 'rgba(0, 188, 212, 0.3)',
                        pointBorderColor: 'rgba(0, 188, 212, 0)',
                        pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                        pointBorderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    legend: false,
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'อายุ (ปี)'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'กก./ต้น'
                            }
                        }]
                    }
                }
            }
        }
    
        return config;
    }

   
});