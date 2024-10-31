import {sideBarToggle} from './utility.js';


sideBarToggle();



// Monthly Orders Chart
var optionsOrders = {
  chart: {
    type: 'bar',
    height: 400,
    background: 'transparent'
  },
  series: [{
    name: 'Orders',
    data: [320, 450, 300, 550, 600, 700, 820, 650, 540, 720, 850, 900] 
  }],
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
  },
  yaxis: {
    title: {
      text: 'Number of Orders'
    }
  },
  plotOptions: {
    bar: {
      borderRadius: 5,
      horizontal: false,
      columnWidth: '50%'
    }
  },
  colors: ['#16325B'], 
  fill: {
    opacity: 0.9
  },
  dataLabels: {
    enabled: false
  },
  title: {
    text: 'Monthly Orders',
    align: 'center',
    style: {
      fontSize: '15px',
      color: '#16325B' 
    }
  },
  grid: {
    show: true,
    borderColor: '#ccc',
    strokeDashArray: 5
  }
};

var chartOrders = new ApexCharts(document.querySelector("#monthly-chart"), optionsOrders);
chartOrders.render();

// Best-Selling Products Donut Chart
var optionsProducts = {
  chart: {
    type: 'donut',
    height: 400,
    background: 'transparent'
  },
  series: [5000, 3500, 2500, 2000, 1500], 
  labels: ['T-Shirts', 'Shoes', 'Accessories', 'Jackets', 'Hats'], 

  colors: ['#16325B', '#1F4C8A', '#254C72', '#3B628D', '#5872A5'], 
  legend: {
    position: 'right',
    horizontalAlign: 'center',
    fontSize: '14px',
    formatter: function(seriesName, opts) {
      var total = opts.w.globals.series.reduce((a, b) => a + b, 0);
      var percentage = ((opts.w.globals.series[opts.seriesIndex] / total) * 100).toFixed(1) + "%";
      return seriesName + " - " + percentage;
    },
    labels: {
      colors: '#4A4947'
    }
  },
  plotOptions: {
    pie: {
      donut: {
        size: '80%',
        labels: {
          show: true,
          total: {
            show: true,
            label: 'Total Income',
            formatter: function(w) {
              return '$14,500'; 
            }
          }
        }
      }
    }
  },
  dataLabels: {
    enabled: false
  }
};

var chartProducts = new ApexCharts(document.querySelector("#products-chart"), optionsProducts);
chartProducts.render();
