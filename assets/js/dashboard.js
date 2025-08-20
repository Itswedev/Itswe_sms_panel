$(function(){

var frmDate = "";
var toDate = ""; 
    load_acct_bal();

var chart,option;
    
    //load_login_users();
    // setInterval(load_login_users,10000);
    load_schedule_count();

    function load_schedule_count()
    {
        //var full_url = window.location.origin;
        var send_data="";
        var user_role=$("#login_user_role").html();
        send_data="user_role="+user_role+"&list_type=load_schedule_count";
        $.ajax({
            url: full_url+'/controller/dashboard_controller.php',
            type: 'post',
            cache: false, 
            data:send_data,
             dataType:'json',
            async:true,

            success: function(data){
             var res = JSON.parse(JSON.stringify(data));
             console.log(res);

           
           

            }
            
          });
    }

    $("#pills-today-tab").click(function(){
        var lbl_series = [];
        var status_val = [];
        //var full_url = window.location.origin;
        var send_data="";
        var user_role=$("#login_user_role").html();
        
        send_data="user_role="+user_role+"list_type=dashboard_chart";
    var lbl_series = [];
    var status_val = [];
     $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:send_data,
                dataType:'json',
                success: function(data){
                    var res = JSON.parse(JSON.stringify(data));
                   
                    console.log(res);                  
                    
                // if(res[0][0]>0)
                // {
                //     var roundedValue;
                //       for(var i=1;i<=res[0][0];i++)
                //         {
                //              //console.log(res[0][i]['status']);
                //                 lbl_series.push(res[0][i]['status']);
                //                 roundedValue = Math.round(res[0][i]['sum_msgcredit']);
                //                 status_val.push(roundedValue);
                //                // status_val.push(res[0][i]['sum_msgcredit']);
                //         }
                // }
                  
                // console.log(status_val);   
                // console.log(lbl_series); 
                // $("#today_total").text(res[1]['chart_data']['total_sent']);
                // $("#today_delivered").text(res[1]['chart_data']['delivered']);
                // $("#today_failed").text(res[1]['chart_data']['failed']);
                // $("#today_sent").text(res[1]['chart_data']['submitted']);


                }
            });
               
    })

    var page_name=$("#page_name").html();
   
    if(page_name=="User" || page_name=="Reseller" || page_name=="Administrator" || page_name=="Admin")
    {
         
        //   load_campaign_status();

        //   load_yearly_traffic();
        //   load_weekly_trend();
        //  // load_sender_performance();
        //  // load_today_statistics();
        //   load_initial_analysis();
          $("#load_analysis_btn").click(function(){
            var check_analysis="";
            load_analysis(check_analysis);

          })
          $(".check_analysis").click(function(){
            var value = $(this).text();
            console.log(value); // Output the text value of the clicked element
            load_analysis(value);

        });


          $("#load_today_graph_btn").click(function(e){
            e.preventDefault();
            var check_statistic="";
            load_user_chart(check_statistic);

          })

          $(".check_statistic").click(function(e){
            e.preventDefault();
            var value = $(this).text();
            console.log(value); // Output the text value of the clicked element
            load_user_chart(value);

        });

          $("#load_template_summary").click(function(e){
            e.preventDefault();
            var check_temp_summary="";
            load_template_summary(check_temp_summary);

          })

          $(".check_summary").click(function(e){
            e.preventDefault();
            var value = $(this).text();
            console.log(value); // Output the text value of the clicked element
            load_template_summary(value);

        });

          $("#load_sender_performance").click(function(){
            load_sender_performance();

          })
   
    //load_analysis();
   // load_template_summary();

   
    load_dashboard_schedule();
          
       // load_user_profile();
    }

    if(page_name=="Administrator" || page_name=="Admin")
    {
     
          top_five_users();
          var dt='This Month';
          load_cut_off_chart(dt);
          $(".dropdown-item").click(function(){

            dt=$(this).text();
            load_cut_off_chart(dt);


          })
       // load_user_profile();
    }

     if(page_name=="Administrator")
    {
          // setInterval(load_live_gateway,5000);
          load_live_gateway();

         // setInterval(load_live_gateway2,5000);
          load_live_gateway2();

      /*  $("#btn_load_userwise_queue").click(function(){

            load_userwise_queue();
        })*/
          

         /*setInterval(load_userwise_queue,40000);
          load_userwise_queue();*/
          
          
       // load_user_profile();
    }

    $("#report_dt").change(function(){
        var check_statistic="";
        load_user_chart(check_statistic);

    })

    if(page_name=="Reseller" || page_name=="Administrator" || page_name=="Admin")
    {
        $("#user_role_dropdown").change(function(){
                load_users();

        })  
    }

    $("#user_dropdown").change(function(){
        var check_statistic="";
        load_user_chart(check_statistic);

    })


})



function load_sender_performance()
{
    //var full_url = window.location.origin;

    $.ajax({
         url: full_url+'/controller/dashboard_controller.php',
         type: 'post',
         cache: false, 
         data:'list_type=load_sender_performance',
          dataType:'json',
         async:true,

         success: function(data){
          var res = JSON.parse(JSON.stringify(data));
          //console.log(res);
            var count=res[0];
            var table_dtls="";
            $("#sender_performance_tbl").empty();
            for(var i=1;i<=count;i++)
            {
                table_dtls+="<tr>";
                table_dtls+="<td></td>";
                table_dtls+="<td>"+res[i][0]+"</td>";
                table_dtls+="<td>"+res[i][1]+"</td>";
                table_dtls+="<td>"+res[i][2]+"</td>";
                table_dtls+="<td>"+res[i][3]+"</td>";
                table_dtls+="<td>"+res[i][4]+"</td>";
                table_dtls+="<td>"+res[i][5]+"</td>";

                table_dtls+="</tr>";

            }
            $("#sender_performance_tbl").append(table_dtls);
            //    $('#recent-product').DataTable().destroy();
            //     $('#recent-product').DataTable();
            // $("#recent-product").DataTables();
            // console.log(table_dtls);
            
        

         }
         
       });

}
function load_today_statistics()
{
  
  var options = {
    series: [{
        name: 'Credit count',
        type: 'area',
        data: [20, 50, 60, 180, 90, 340, 120, 250, 190, 100, 180, 380, 190, 220, 100, 90, 140, 70, 130, 90, 100, 50]
    }],
    chart: {
        height: 270,
        type: 'line',
        toolbar: {
            show: false,
        },
        dropShadow: {
            enabled: true,
            top: 4,
            left: 1,
            blur: 8,
            color: [MofiAdminConfig.primary, '#8D8D8D'],
            opacity: 0.6
        },

    },
    stroke: {
        curve: 'smooth',
        width: [3, 3],
        dashArray: [0, 4]

    },
    grid: {
        show: true,
        borderColor: 'rgba(106, 113, 133, 0.30)',
        strokeDashArray: 3,
    },
    fill: {
        type: 'solid',
        opacity: [0, 1],
    },

    labels: ['Jan', '', 'Feb', '', 'Mar', '', 'Apr', '', 'May', '', 'Jun', '', 'Jul', '', 'Aug', '', 'Sep', '', 'Oct', '', 'Nov', '', 'Dec'],
    markers: {
        size: [3, 0],
        colors: ['#3D434A'],
        strokeWidth: [0, 0],
    },
    responsive: [
        {
            breakpoint: 991,
            options: {
                chart: {
                    height: 300
                }
            }
        },
        {
            breakpoint: 1500,
            options: {
                chart: {
                    height: 325
                }
            }
        }
    ],
    tooltip: {
        shared: true,
        intersect: false,
        y: {
            formatter: function (y) {
                if (typeof y !== "undefined") {
                    return y.toFixed(0) + "";
                }
                return y;
            }
        }
    },
    annotations: {
        xaxis: [{
            x: 550,
            strokeDashArray: 5,
            borderWidth: 3,
            borderColor: '#7a70ba69',
        },
        ],
        points: [{
            x: 550,
            y: 330,
            marker: {
                size: 8,
                fillColor: MofiAdminConfig.primary,
                strokeColor: "#ffffff",
                strokeWidth: 4,
                radius: 5,
            },
            label: {
                borderWidth: 1,
                offsetY: 0,
                text: '32.10k',
                style: {
                    fontSize: '14px',
                    fontWeight: '600',
                    fontFamily: 'Outfit, sans-serif',
                }
            }
        }],
    },
    legend: {
        show: false,
    },
    colors: [MofiAdminConfig.primary, '#8D8D8D'],
    xaxis: {
        labels: {
            style: {
                fontFamily: 'Outfit, sans-serif',
                fontWeight: 500,
                colors: '#8D8D8D',
            },
        },
        axisBorder: {
            show: false
        },
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                return value + "k";
            },
            style: {
                fontFamily: 'Outfit, sans-serif',
                fontWeight: 500,
                colors: '#3D434A',
            },
        },
    },
    responsive: [
        {
            breakpoint: 576,
            options: {
                series: [{
                    name: 'Credit Count',
                    type: 'area',
                    data: [ 50, 60, 180, 90, 340, 120, 250, 190, 100, 180, 380, 190, 220, 100, 90, 140]
                }],
            }
        },
    ]
};
var chart = new ApexCharts(document.querySelector("#chart-dash-2-line"), options);
chart.render();
}
function load_campaign_status()
{
  //var full_url = window.location.origin;

           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_campaign_status',
                 dataType:'json',
                async:true,

                success: function(data){
                 var res = JSON.parse(JSON.stringify(data));
                 console.log(res);

                 $("#upcoming_campaign").text(res['upcoming']);
                 $("#completed_campaign").text(res['completed']);
                 $("#total_campaign").text(res['total']);
                 $("#progress_campaign").text(0);
               

                }
                
              });
}

function load_initial_analysis()
{
    
                   // ----------Shifts Overview-----//
                   option = {
                    labels: ["Sent", "Delivered", "Failed", "Template Mismatch"],
                    series: [0,0,0,0],
                    chart: {
                        type: "donut",
                        height: 200,
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        show: false,
                    },
                    stroke: {
                        width: 6,
                    },
                    plotOptions: {
                        pie: {
                            expandOnClick: false,
                            donut: {
                                size: "83%",
                                labels: {
                                    show: true,
                                    name: {
                                        offsetY: 4,
                                    },
                                    total: {
                                        show: true,
                                        fontSize: "20px",
                                        fontFamily: "Outfit', sans-serif",
                                        fontWeight: 600,
                                        label: 0,
                                        formatter: () => "Total Sent",
                                    },
                                },
                            },
                        },
                    },
                    states: {
                        normal: {
                            filter: {
                                type: "none",
                            },
                        },
                        hover: {
                            filter: {
                                type: "none",
                            },
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: "none",
                            },
                        },
                    },
                    colors: ["#48A3D7", "#D77748", "#C95E9E", "#7A70BA"],
                };

                 chart = new ApexCharts(
                    document.querySelector("#shifts-overview"),
                    option
                );
                chart.render();
}


function load_analysis(check_analysis)
{
  //var full_url = window.location.origin;

           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_analysis&check_analysis='+check_analysis,
                 dataType:'json',
                async:true,

                success: function(data){
                 var res = JSON.parse(JSON.stringify(data));
                // console.log(res['total_sent']);
                 //res=[20000,9000,40000,0];
                 $("#sent").text(res['statuswise'][0]);
                //  $("#today_total").text(res['total_sent']);
                //  $("#today_delivered").text(res['statuswise'][1]);
                 $("#mismatch").text(res['statuswise'][3]);
                 $("#delivered").text(res['statuswise'][1]);
                 $("#failed").text(res['statuswise'][2]);
                //  $("#today_failed").text(res['statuswise'][2]);
                    
                   // ----------Shifts Overview-----//

                   option.series = [res['statuswise'][0], res['statuswise'][1], res['statuswise'][2], res['statuswise'][3]];
                   option.plotOptions.pie.donut.labels.total.label = res['total_sent']; 
                   chart.updateOptions(option);
                   if(check_analysis!='')
                    {
                        $("#show_analysis").text(check_analysis);
                    }
                    else
                    {
                        $("#show_analysis").text('Today');

                    }
                  

                //    var option = {
                //     labels: ["Sent", "Delivered", "Failed", "Template Mismatch"],
                //     series: [res['statuswise'][0], res['statuswise'][1], res['statuswise'][2], res['statuswise'][3]],
                //     chart: {
                //         type: "donut",
                //         height: 200,
                //     },
                //     dataLabels: {
                //         enabled: false,
                //     },
                //     legend: {
                //         show: false,
                //     },
                //     stroke: {
                //         width: 6,
                //     },
                //     plotOptions: {
                //         pie: {
                //             expandOnClick: false,
                //             donut: {
                //                 size: "83%",
                //                 labels: {
                //                     show: true,
                //                     name: {
                //                         offsetY: 4,
                //                     },
                //                     total: {
                //                         show: true,
                //                         fontSize: "20px",
                //                         fontFamily: "Outfit', sans-serif",
                //                         fontWeight: 600,
                //                         label: res['total_sent'],
                //                         formatter: () => "Total Sent",
                //                     },
                //                 },
                //             },
                //         },
                //     },
                //     states: {
                //         normal: {
                //             filter: {
                //                 type: "none",
                //             },
                //         },
                //         hover: {
                //             filter: {
                //                 type: "none",
                //             },
                //         },
                //         active: {
                //             allowMultipleDataPointsSelection: false,
                //             filter: {
                //                 type: "none",
                //             },
                //         },
                //     },
                //     colors: ["#48A3D7", "#D77748", "#C95E9E", "#7A70BA"],
                // };

                // chart = new ApexCharts(
                //     document.querySelector("#shifts-overview"),
                //     option
                // );
                // chart.render();

                 //analysis graph
                  //updateChartData(res['statuswise'],res['total_sent']);

                }
                
              });
}




function load_yearly_traffic()
{
  //var full_url = window.location.origin;

           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_yearly_traffic',
                 dataType:'json',
                async:true,

                success: function(data){
                 // alert('asgfj');
                var res = JSON.parse(JSON.stringify(data));
               console.log(res);

                var month=res['yearly_traffic'][0];
                var total_data=res['yearly_traffic'][1];
                
                var delivered=res['yearly_traffic'][2];
                // console.log(delivered);
                var failed=res['yearly_traffic'][3];

                              var options = {
                                series: [{
                                    type: 'bar',
                                    data: total_data,
                                    name: 'Total'
                                }, {
                                    type: 'bar',
                                    data: delivered,
                                    name: 'Delivrd'
                                },
                                {
                                    type: 'line',
                                    data: failed,
                                    name: 'Undelivrd'

                                }],
                                chart: {
                                    height: 350,
                                    toolbar: {
                                        show: false
                                    },
                                },
                                markers: {
                                    size: 6,
                                    strokeColor: "#ffffff",
                                    strokeWidth: 3,
                                    offsetX: -3,
                                    strokeOpacity: 1,
                                    fillOpacity: 1,
                                    hover: {
                                        size: 6
                                    }
                                },
                                hover: {
                                    size: 5,
                                    sizeOffset: 0,
                                },
                                plotOptions: {
                                    bar: {
                                        vertical: true,
                                        columnWidth: '60%',
                                        borderRadius: 6,
                                        dataLabels: {
                                            position: 'top',
                                        },
                                    }
                                },
                                grid: {
                                    show: true,
                                    strokeDashArray: 5,
                                    position: 'back',
                                    xaxis: {
                                        lines: {
                                            show: false
                                        }
                                    },
                                },
                                legend: {
                                    show: false,
                                },
                                dataLabels: {
                                    enabled: false,
                                    offsetX: -6,
                                    style: {
                                        fontSize: '14px',
                                        fontWeight: 600,
                                        colors: ['#fff']
                                    }
                                },
                                stroke: {
                                    show: true,
                                    width: [4, 4, 3],
                                    colors: ['#ffffff', '#ffffff', '#C95E9E']
                                },
                                colors: [MofiAdminConfig.primary, MofiAdminConfig.secondary,'#C95E9E'],
                                tooltip: {
                                    shared: true,
                                    intersect: false
                                },
                                xaxis: {
                                    categories: month,
                                    axisBorder: {
                                        show: false
                                    },
                                    labels: {
                                        style: {
                                            fontFamily: 'Outfit, sans-serif',
                                            fontWeight: 500,
                                            colors: '#8D8D8D',
                                        },
                                    },
                                },
                                yaxis: {
                                    labels: {
                                        style: {
                                            fontFamily: 'Outfit, sans-serif',
                                            fontWeight: 500,
                                            colors: '#3D434A',
                                        },
                                    },
                                },
                                responsive: [
                                    {
                                        breakpoint: 1400,
                                        options: {
                                            series: [{
                                                type: 'bar',
                                                data: total_data
                                            }, {
                                                type: 'bar',
                                                data: delivered
                                            }],
                                        }
                                    },
                                    {
                                        breakpoint: 1200,
                                        options: {
                                            series: [{
                                                type: 'bar',
                                                data: total_data
                                            }, {
                                                type: 'bar',
                                                data: delivered
                                            }
                                            ],
                                        }
                                    },
                                  
                                ]
                            };

                            var chart = new ApexCharts(document.querySelector("#customer-transaction"), options);
                            chart.render();





                
              //   var options = {
              //     series: [{
              //         type: 'bar',
              //         data: total_data,
              //         name: 'Total'
              //     }, {
              //         type: 'bar',
              //         data: delivered,
              //         name: 'Delivrd'
              //     }, {
              //         type: 'line',
              //         data: failed,
              //         name: 'Undelivrd'
              //     }],
              //     chart: {
              //         height: 350,
              //         toolbar: {
              //             show: false
              //         },
              //     },
              //     markers: {
              //         size: 6,
              //         strokeColor: "#ffffff",
              //         strokeWidth: 3,
              //         offsetX: -3,
              //         strokeOpacity: 1,
              //         fillOpacity: 1,
              //         hover: {
              //             size: 6
              //         }
              //     },
              //     hover: {
              //         size: 5,
              //         sizeOffset: 0,
              //     },
              //     plotOptions: {
              //         bar: {
              //             vertical: true,
              //             columnWidth: '60%',
              //             borderRadius: 6,
              //             dataLabels: {
              //                 position: 'top',
              //             },
              //         }
              //     },
              //     grid: {
              //         show: true,
              //         strokeDashArray: 5,
              //         position: 'back',
              //         xaxis: {
              //             lines: {
              //                 show: false
              //             }
              //         },
              //     },
              //     legend: {
              //         show: false,
              //     },
              //     dataLabels: {
              //         enabled: false,
              //         offsetX: -6,
              //         style: {
              //             fontSize: '14px',
              //             fontWeight: 600,
              //             colors: ['#fff']
              //         }
              //     },
              //     stroke: {
              //         show: true,
              //         width: [4, 4, 3],
              //         colors: ['#ffffff', '#ffffff', MofiAdminConfig.primary]
              //     },
              //     colors: [MofiAdminConfig.primary, MofiAdminConfig.secondary],
              //     tooltip: {
              //         shared: true,
              //         intersect: false
              //     },
              //     xaxis: {
              //         categories: month,
              //         axisBorder: {
              //             show: false
              //         },
              //         labels: {
              //             style: {
              //                 fontFamily: 'Outfit, sans-serif',
              //                 fontWeight: 500,
              //                 colors: '#8D8D8D',
              //             },
              //         },
              //     },
              //     yaxis: {
              //         labels: {
              //             style: {
              //                 fontFamily: 'Outfit, sans-serif',
              //                 fontWeight: 500,
              //                 colors: '#3D434A',
              //             },
              //         },
              //     },
              //     responsive: [
              //         {
              //             breakpoint: 1400,
              //             options: {
              //                 series: [{
              //                     type: 'bar',
              //                     data: total_data.slice(0, 5)
              //                 }, {
              //                     type: 'bar',
              //                     data: delivered.slice(0, 5)
              //                 }],
              //             }
              //         },
              //         {
              //             breakpoint: 1200,
              //             options: {
              //                 series: [{
              //                     type: 'bar',
              //                     data: total_data.slice(0, 8)
              //                 }, {
              //                     type: 'bar',
              //                     data: delivered.slice(0, 8)
              //                 }],
              //             }
              //         },
              //     ]
              // };
              
              // var chart = new ApexCharts(document.querySelector("#customer-transaction"), options);
              // chart.render();   

                }
                
              });
}


function load_weekly_trend()
{
   
    
  //var full_url = window.location.origin;

           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_weekly_trend',
                dataType:'json',
                async:true,

                success: function(data){
                 // alert('asgfj');
                var res = JSON.parse(JSON.stringify(data));
                var month=res['weekly_trend'][0];
                var total_data=res['weekly_trend'][1];
                
                console.log(res);
                var growthoptions = {
                  series: [{
                      name: 'Usage',
                      data: total_data
                  }],
                  chart: {
                      height: 150,
                      type: 'line',
                      stacked: true,
                      toolbar: {
                          show: false
                      },
                      dropShadow: {
                          enabled: true,
                          enabledOnSeries: undefined,
                          top: 5,
                          left: 0,
                          blur: 4,
                          color: '#7A70BA',
                          opacity: 0.22
                      },
                  },
                  grid: {
                      show: true,
                      borderColor: '#000000',
                      strokeDashArray: 0,
                      position: 'back',
                      xaxis: {
                          lines: {
                              show: true,
                          },
                      },
                      yaxis: {
                          lines: {
                              show: false,
                          },
                      },
                  },
              
                  colors: ["#5527FF"],
                  stroke: {
                      width: 3,
                      curve: 'smooth'
                  },
                  xaxis: {
                      lines: {
                          show: true
                      },
                      type: 'category',
                      categories: month, // Use the function to get last 7 days
                      tickAmount: 7, // Set the number of ticks to display
                      labels: {
                          style: {
                              fontFamily: 'Outfit, sans-serif',
                              fontWeight: 500,
                              colors: '#8D8D8D',
                          },
                      },
                      axisTicks: {
                          show: false
                      },
                      axisBorder: {
                          show: false
                      },
                      tooltip: {
                          enabled: false,
                      },
                  },
                  fill: {
                      type: 'gradient',
                      gradient: {
                          shade: 'dark',
                          gradientToColors: ['#5527FF'],
                          shadeIntensity: 1,
                          type: 'horizontal',
                          opacityFrom: 1,
                          opacityTo: 1,
                          colorStops: [
                              {
                                  offset: 0,
                                  color: "#7A70BA",
                                  opacity: 1
                              },
                              {
                                  offset: 100,
                                  color: "#48A3D7",
                                  opacity: 1
                              },
                          ]
                      },
                  },
                  yaxis: {
                      labels: {
                          show: false
                      },
                  }
              };


              var growthchart = new ApexCharts(document.querySelector("#growthchart"), growthoptions);
              growthchart.render();


                }
                
              });
}


function load_template_summary(check_temp_summary)
{
  //var full_url = window.location.origin;

           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_template_summary&check_temp_summary='+check_temp_summary,

                async:true,

                success: function(data){
                //  var res = JSON.parse(JSON.stringify(data));
                $("#template_summary_body").empty();
                $("#template_summary_body").append(data);
                if(check_temp_summary!='')
                    {
                        $("#show_temp_summary").text(check_temp_summary);
                    }
                    else
                    {
                        $("#show_temp_summary").text('Today');

                    }
                // $('#template_summary').DataTable().destroy();
                // $('#template_summary').DataTable();
                

                }
                
              });
}
function updateChartData(newSeries,total_sent) {
    if (window.myNamespace.chart) {
      window.myNamespace.chart.updateOptions({
          series: newSeries,
          plotOptions: {
            pie: {
                donut: {
                    labels: {
                        total: {
                            label: total_sent.toString(), // Update the label with the new total value
                            formatter: () => "Total Sent", // Update the formatter function to return the new total value
                        }
                    }
                }
            }
        }
      });
  } else {
      console.error("Chart object not found.");
  }
}
function load_live_gateway()
{
    //var full_url = window.location.origin;

           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_live_gateway',
                 dataType:'json',
                async:true,

                success: function(data){
                 var res = JSON.parse(JSON.stringify(data));
                   
                    /*console.log(res);*/
                    var count_gateway=res['gateway_names'].length;
                    $("#gateway_status").html(res['status']);                
                    
                    $("#sms_total_sent").html(res['sms_total_sent']);
                     $("#sms_total_queued").html(res['sms_total_queued']);
                      $("#sms_total_inbound").html(res['sms_total_inbound']);

                      $("#dlr_total_sent").html(res['dlr_total_sent']);
                     $("#dlr_total_queued").html(res['dlr_total_queued']);
                     $("#sms_total_store_size").html(res['sms_store_size']);
                     

                      $("#dlr_total_inbound").html(res['dlr_total_inbound']);
                      $("#boxes_dtls").html(res['boxes_dtls']);
                      var gateway_name_tbl="";
                      $("#gateway_dtls_tbl").empty();
                      for(var i=0;i<count_gateway;i++)
                      {
                        
                        var gateway_name=res['gateway_names'][i].trim();
                        var gateway_status=res['gateway_status'][gateway_name];
                        var queued=res['queued'][gateway_name];
                        gateway_name_tbl+="<tr>  <td><div class='d-flex align-items-center'>     <div class='flex-shrink-0'><img src='assets/images/dashboard/project/1.png' alt='' style='border-radius: 20px;'></div><div class='flex-grow-1 ms-2'><a href='#'><h6>"+gateway_name+"</h6></a></div></div></td>"+
                       //gateway_name_tbl+="<tr><td>"+gateway_name+"</td>"+
                        
                        "<td>"+queued+"</td>"+
                        
                        
                        "<td>";
                        var ports=res['ports'][gateway_name];
                        /*for(var j=0;j<ports.length;j++)
                        {*/
                            var port_name=ports[0];
                            var tx_count=res['tx_count'][gateway_name];
                            var rx_count=res['rx_count'][gateway_name];
                            var trx_count=res['trx_count'][gateway_name];
                            if(tx_count==null)
                            {
                                tx_count=0;
                            }

                               if(rx_count==null)
                            {
                                rx_count=0;
                            }

                               if(trx_count==null)
                            {
                                trx_count=0;
                            }
                           /* var tx_count=ports[1];*/

                            gateway_name_tbl+="TX-"+tx_count+"&nbsp;";
                            gateway_name_tbl+="RX-"+rx_count+"&nbsp;";
                             gateway_name_tbl+="TRX-"+trx_count+"&nbsp;";

                        //}
                        
                       //console.log(gateway_status);
                        gateway_name_tbl+="</td>";

                        if(gateway_status=='Dead')
                        {
                          gateway_name_tbl+="<td class='project-dot'><div class='d-flex'><div class='flex-shrink-0'><span class='bg-danger'></span></div>    <div class='flex-grow-1'><h6>"+gateway_status+"</h6></div></div></td>";
                        }
                        else if (gateway_status=='Re-connecting'){
                          gateway_name_tbl+="<td class='project-dot'><div class='d-flex'><div class='flex-shrink-0'><span class='bg-warning'></span></div>    <div class='flex-grow-1'><h6>"+gateway_status+"</h6></div></div></td>";
                        }
                        else{
                          gateway_name_tbl+="<td class='project-dot'><div class='d-flex'><div class='flex-shrink-0'><span class='bg-success'></span></div>    <div class='flex-grow-1'><h6>"+gateway_status+"</h6></div></div></td>";
                        }
                       // gateway_name_tbl+="<td>"+gateway_status+"</td>";
                        //console.log(gateway_name);
                        gateway_name_tbl+="<td><a href=javascript:start_smsc('"+gateway_name+"');>start</a>/<a href=javascript:stop_smsc('"+gateway_name+"');>stop</a></td>";

                        gateway_name_tbl+="</tr>";
                      }

                      //console.log(gateway_name_tbl);
                      $("#gateway_dtls_tbl").append(gateway_name_tbl);

                      // $("#live_gateway1").DataTable();

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    
                  }
            });
}
function submit_form (action, smsc, level) {
  document.getElementById("action").value = action;
  document.getElementById("smsc").value = smsc;
  document.getElementById("level").value = level;
  document.getElementById("form").submit();
}


function start_smsc (smsc, ask) {
  if (ask == false || confirm("Are you sure you want to restart gateway '"+smsc+"'?"))
      submit_form("start", smsc, "");
}
function stop_smsc (smsc) {
  if (confirm("Are you sure you want to terminate gateway '"+smsc+"'?"))
      submit_form("stop", smsc, "");
}

function load_live_gateway2()
{
    //var full_url = window.location.origin;

           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_live_gateway2',
                 dataType:'json',
                async:true,

                success: function(data){
                 var res = JSON.parse(JSON.stringify(data));
                   
                    /*console.log(res);*/
                    var count_gateway=res['gateway_names'].length;
                    $("#gateway_status2").html(res['status']);                
                    
                    $("#sms_total_sent2").html(res['sms_total_sent']);
                     $("#sms_total_queued2").html(res['sms_total_queued']);
                      $("#sms_total_inbound2").html(res['sms_total_inbound']);

                      $("#dlr_total_sent2").html(res['dlr_total_sent']);
                     $("#dlr_total_queued2").html(res['dlr_total_queued']);
                     $("#sms_total_store_size2").html(res['sms_store_size']);
                     

                      $("#dlr_total_inbound2").html(res['dlr_total_inbound']);
                      $("#boxes_dtls2").html(res['boxes_dtls']);
                      var gateway_name_tbl="";
                      $("#gateway_dtls_tbl2").empty();
                      for(var i=0;i<count_gateway;i++)
                      {
                        
                        var gateway_name=res['gateway_names'][i];
                        var gateway_status=res['gateway_status'][gateway_name];
                        var queued=res['queued'][gateway_name];
                        gateway_name_tbl+="<tr><td>"+gateway_name+"</td>"+
                        "<td>"+queued+"</td>"+
                        
                        "<td>";
                        var ports=res['ports'][gateway_name];
                        /*for(var j=0;j<ports.length;j++)
                        {*/
                            var port_name=ports[0];
                            var tx_count=res['tx_count'][gateway_name];
                            var rx_count=res['rx_count'][gateway_name];
                            var trx_count=res['trx_count'][gateway_name];
                            if(tx_count==null)
                            {
                                tx_count=0;
                            }

                               if(rx_count==null)
                            {
                                rx_count=0;
                            }

                               if(trx_count==null)
                            {
                                trx_count=0;
                            }
                           /* var tx_count=ports[1];*/

                            gateway_name_tbl+="<span class='badge badge-soft-info'>TX-"+tx_count+"</span>&nbsp;";
                            gateway_name_tbl+="<span class='badge badge-soft-info'>RX-"+rx_count+"</span>&nbsp;";
                             gateway_name_tbl+="<span class='badge badge-soft-info'>TRX-"+trx_count+"</span>&nbsp;";

                        //}
                        
                       
                        gateway_name_tbl+="</td>";
                        gateway_name_tbl+="<td>"+gateway_status+"</td>";

                        gateway_name_tbl+="</tr>";
                      }

                      $("#gateway_dtls_tbl2").append(gateway_name_tbl);

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    
                  }
            });
}



function load_userwise_queue()
{
    //var full_url = window.location.origin;

           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_userwise_queue',
                dataType:'json',
                async:true,

                success: function(data){
                 var res = JSON.parse(JSON.stringify(data));
                    /*console.log(res);*/
                   
                    var dt=new Date();
                    console.log(dt);
                    $("#userwise_queue_time").html(dt);
                    if(res!=0)
                    {
                        /*console.log("userwise1");*/
                         $("#userwise_queue").empty();
                         var username='',queue=0;
                         var table_data="";
                        for(var i=0;i<res.length;i++)
                          {
                                username=res[i][2];
                                queue=res[i][0];
                                table_data+="<li class='d-flex'>"+
                                 "<div class='flex-shrink-0 bg-light-primary'><img src='assets/images/dashboard/icon/wallet.png' alt='Wallet'></div>"+
                                 "<div class='flex-grow-1'> <a href='private-chat.html'>"+
                                     "<h5>"+username+"</h5></a>"+
                                   "<p class='text-truncate'></p>"+
                                 "</div><span>"+queue+"</span>"+
                               "</li>";
                                
                          }
                          $("#userwise_queue").append(table_data);

                        
                    }
                    else
                    {
                        count=0;
                        $("#userwise_queue").empty();
                        table_data="<tr><td colspan=2>No Queue</td>"+"</tr>";
                         $("#userwise_queue").append(table_data);
                        /*$("#userwise_queue").append(gateway_name_tbl);*/
                        
                    }


                                       /* var count_gateway=res['gateway_names'].length;
                   
                      var gateway_name_tbl="";
                      $("#userwise_queue").empty();
                      for(var i=0;i<count_gateway;i++)
                      {
                        
                        var gateway_name=res['gateway_names'][i];
                        var gateway_status=res['gateway_status'][gateway_name];
                        var queued=res['queued'][gateway_name];
                        gateway_name_tbl+="<tr><td>"+gateway_name+"</td>"+
                        "<td>"+queued+"</td>"+
                        
                        "<td>";
                        
                              

                            gateway_name_tbl+="<span class='badge badge-soft-info'>TX-"+tx_count+"</span>&nbsp;";
                            gateway_name_tbl+="<span class='badge badge-soft-info'>RX-"+rx_count+"</span>&nbsp;";
                             gateway_name_tbl+="<span class='badge badge-soft-info'>TRX-"+trx_count+"</span>&nbsp;";

                        
                        
                       
                        gateway_name_tbl+="</td>";
                        gateway_name_tbl+="<td>"+gateway_status+"</td>";

                        gateway_name_tbl+="</tr>";
                      }

                      $("#userwise_queue").append(gateway_name_tbl);*/

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    
                  }
            });
}
var chart1;
function load_user_chart(check_statistic)
{

    var page=$("#page_name").html();
    var report_dt=$("#report_dt").val();
    var user=$("#user_dropdown").val();  
    var selected_role=$("#user_role_dropdown").val();  
    //var full_url = window.location.origin;
    
  
    var send_data="";
    if(report_dt!="" && user=="")
    {
        
        send_data="list_type=user_chart&dt="+report_dt+"&page_name="+page+"&selected_role="+selected_role+"&check_statistic="+check_statistic;
    }
    else if(user!="" && report_dt=="")
    {
         
        send_data="list_type=user_chart&uid="+user+"&page_name="+page+"&selected_role="+selected_role+"&check_statistic="+check_statistic;
    }
    else if(user!="" && report_dt!="")
    {
        
        send_data="list_type=user_chart&uid="+user+"&page_name="+page+"&dt="+report_dt+"&selected_role="+selected_role+"&check_statistic="+check_statistic;
    }
    else{
          
        send_data="list_type=user_chart&page_name="+page+"&selected_role="+selected_role+"&check_statistic="+check_statistic;
    }

    var lbl_series = [];
    var status_val = [];
     $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:send_data,
                dataType:'json',
                success: function(data){
                    var res = JSON.parse(JSON.stringify(data));
                   
                    console.log(res);                  
                    
                if(res[0][0]>0)
                {
                    var roundedValue;
                      for(var i=1;i<=res[0][0];i++)
                        {
                             //console.log(res[0][i]['status']);
                                lbl_series.push(res[0][i]['status']);
                                roundedValue = Math.round(res[0][i]['sum_msgcredit']);
                                status_val.push(roundedValue);
                               // status_val.push(res[0][i]['sum_msgcredit']);
                        }
                }
                  
                console.log(status_val);   
                console.log(lbl_series); 
                $("#today_total").text(res[1]['chart_data']['total_sent']);
                $("#today_delivered").text(res[1]['chart_data']['delivered']);
                $("#today_failed").text(res[1]['chart_data']['failed']);
                $("#today_sent").text(res[1]['chart_data']['submitted']);
                if(check_statistic!='')
                    {
                        $("#static_lbl").text(check_statistic);
                    }
                    else
                    {
                        $("#static_lbl").text('Today');

                    }
               // $("#static_lbl").text(check_statistic);
                // $("#today_total").text(res[0][1]);
                
               // lbl_series =  ['Barring', 'Delivered', 'Failed', 'invalid Number', 'Memory Capacity Exceeded', 'NDNC Failed', 'Network Error', 'Other', 'Submitted'];
                var options = {
                    series: [{
                        name: 'Credit count',
                        type: 'area',
                        data: status_val
                    }],
                    chart: {
                        height: 270,
                        type: 'line',
                        toolbar: {
                            show: false,
                        },
                        dropShadow: {
                            enabled: true,
                            top: 4,
                            left: 1,
                            blur: 8,
                            color: [MofiAdminConfig.primary, '#8D8D8D'],
                            opacity: 0.6
                        },
                    },
                    stroke: {
                        curve: 'smooth',
                        width: [3, 3],
                        dashArray: [0, 4]
                    },
                    grid: {
                        show: true,
                        borderColor: 'rgba(106, 113, 133, 0.30)',
                        strokeDashArray: 3,
                    },
                    fill: {
                        type: 'solid',
                        opacity: [0, 1],
                    },
                    labels: lbl_series,
                    markers: {
                        size: [3, 0],
                        colors: ['#3D434A'],
                        strokeWidth: [0, 0],
                    },
                    responsive: [{
                            breakpoint: 991,
                            options: {
                                chart: {
                                    height: 300
                                }
                            }
                        },
                        {
                            breakpoint: 1500,
                            options: {
                                chart: {
                                    height: 325
                                }
                            }
                        }
                    ],
                    tooltip: {
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: function(y) {
                                if (typeof y !== "undefined") {
                                    return y.toFixed(0) + "";
                                }
                                return y;
                            }
                        }
                    },
                    legend: {
                        show: false,
                    },
                    colors: [MofiAdminConfig.primary, '#8D8D8D'],
                    xaxis: {
                        categories: lbl_series,
                        labels: {
                            style: {
                                fontFamily: 'Outfit, sans-serif',
                                fontWeight: 500,
                                colors: '#8D8D8D',
                            },
                            rotate: -45, // Adjust the rotation angle of x-axis labels
                            rotateAlways: true 
                            
                        },
                        axisBorder: {
                            show: false
                        },
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                // Check if the value is greater than or equal to 1000
                                if (value >= 1000) {
                                    // Divide the value by 1000 and round it to 2 decimal places
                                    var formattedValue = (value / 1000).toFixed(2);
                                    // Append the "k" suffix to the formatted value
                                    return formattedValue + "k";
                                } else {
                                    // If the value is less than 1000, simply return it as is
                                    return value ;
                                }
                            },
                            style: {
                                fontFamily: 'Outfit, sans-serif',
                                fontWeight: 500,
                                colors: '#3D434A',
                            },
                        },
                    },
                    responsive: [{
                        breakpoint: 576,
                        options: {
                            series: [{
                                name: 'Credit Count',
                                type: 'area',
                                data: status_val
                            }],
                        }
                    }]
                };
                
                if(chart1)
                    {
                        chart1.destroy();
                    }
                chart1 = new ApexCharts(document.querySelector("#chart-dash-2-line"), options);
                chart1.render();

                //$("#SvgjsSvg2406").css('height','400px');
                

                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    //alert(errorMsg);
                   // location.reload();
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_users()
{
    //var full_url = window.location.origin;

    var role=$("#user_role_dropdown").val();
    $(".role_name").text(role);
           $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_userslist&role='+role,
                async:true,

                success: function(data){
                    var cleanedData = data.replace(/\s+/g, ' ').trim(); // Remove all types of extra whitespace
                    console.log(cleanedData);
                    alert('asjgdf');
              
                  $("#user_dropdown").empty();
                  $("#user_dropdown").append('<option>test</option>');
                 // $("#user_dropdown").append(cleanedData);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    console.log(data);
                     //location.reload();
                    //$('#content').html(errorMsg);
                  }
            });
}
function load_dashboard_schedule()
{
    //var full_url = window.location.origin;
    $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_schedule',
                async:true,

                success: function(data){
                    var schedule_arr=data.split(",");
                    var schedule_list="";
                 $("#management-calendar-events").empty();
                 for(var i=0;i<(schedule_arr.length-1);i++)
                 {
                    var schedule_data=schedule_arr[i].split("|");
                    var username=schedule_data[0];
                    var job_id=schedule_data[1];
                    var sent_at=schedule_data[2];
                    var total_credit=schedule_data[3];
                     schedule_list+='<li class="border-top pt-3 mb-3 pb-1 cursor-pointer" data-calendar-events="">'+
                    '<div class="border-start border-3 border-primary ps-3 mt-1">'+
                      '<h6 class="mb-1 fw-semi-bold text-700">'+username+' <br>( '+job_id+' - '+total_credit+' )</h6>'+
                      '<p class="fs--2 text-600 mb-0">'+sent_at+'</p>'+
                    '</div>'+
                  '</li> ';
                 }

            
          $("#management-calendar-events").append(schedule_list);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    //alert(data);
                     //location.reload();
                    //$('#content').html(errorMsg);
                  }
            });
     
         

}

function top_five_users()
{
    //var full_url = window.location.origin;

  
  
           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=top_five_users',
                async:true,

                success: function(res){
                 
                  var top_five_users_list="";
                  res=res.trim();
                  // console.log(res);
                  var all_users=res.split(",");
                  for(var i=0;i<(all_users.length-1);i++)
                  {

                      top_five_users_list+="<tr>";
                   
                    var userdata=all_users[i].split("|");
                    var username=userdata[0];
                    var credit_count=userdata[1];
                    var profile_pic=userdata[2];
                     if(profile_pic=='')
                     {
                        profile_pic_path='assets/images/profile/profile_default.png';
                     }
                     else
                     {
                        profile_pic_path='assets/images/profile/'+profile_pic;
                     }
                     
                    top_five_users_list+="<td><div class='d-flex align-items-center'><div class='flex-shrink-0'><img width='36px' src='"+profile_pic_path+"' alt=''></div><div class='flex-grow-1'><a href='#'><h5>"+username+"</h5></a></div></div></td>";
                     top_five_users_list+="<td><p class='members-box background-light-primary text-center b-light-primary font-primary'> "+credit_count+"</p></td>";

                    top_five_users_list+="</tr>";
                    // console.log(top_five_users_list);
                  }

                


                  $("#top_five_user_list").empty();
                  // $("#top_five_user_list").append("<tr><td><div class='d-flex align-items-center'><div class='flex-shrink-0'><img src='assets/images/profile/profile_default.png' alt=''></div><div class='flex-grow-1'><a href='#'><h5>shoaib</h5></a><span>UI/UX Designer</span></div></div></td><td> 02 hours</td><td><p class='members-box background-light-primary text-center b-light-primary font-primary'> 1199992</p></td></tr>");
                  // console.log("Test val");
                  // console.log("<tr><td><div class='d-flex align-items-center'><div class='flex-shrink-0'><img src='assets/images/profile/profile_default.png' alt=''></div><div class='flex-grow-1'><a href='#'><h5>shoaib</h5></a><span>UI/UX Designer</span></div></div></td><td> 02 hours</td><td><p class='members-box background-light-primary text-center b-light-primary font-primary'> 1199992</p></td></tr>");
                  $("#top_five_user_list").append(top_five_users_list);

                 /* $("#top_users_list").empty();
                  $("#top_users_list").append(data);*/
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    //alert(data);
                   //  location.reload();
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_cut_off_chart(dt)
{
    //var full_url = window.location.origin;

  
  
           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_cut_off_chart&dt='+dt,
                dataType:'json',
                async:true,

                success: function(data){
               
                var res = JSON.parse(JSON.stringify(data));
                    //console.log(res[0]);
                        var total_submitted=res[0];
                        var total_cutoff=res[1];
                        $("#cut_off_percentage").html(total_cutoff+" - Credits Cutoff");

                        $("#total_credit_cut").html(total_submitted+" - Total Submission");

                        //var cutting_per=parseInt((total_cutoff/total_submitted)*100);
                        // $("#smart_graph").attr('data-options', "{'color':'url(#gradient)','progress':"+cutting_per+",'strokeWidth':5,'trailWidth':5}");

                  /* const data2 = {
                      labels: ['Submitted', 'Cut Off'],
                      datasets: [{
                        label: 'Smart Cut-Off', 
                        data: [total_submitted, total_cutoff],
                        backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)'], 
                        hoverOffset: 4
                      }]
                    };

                    const config2 = {
                      type: 'pie',
                      data: data2,
                      options: {}
                    };

                    const myChart2 = new Chart(document.getElementById('myChart2').getContext('2d'), config2);

       
                    myChart2.update();*/

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                   // alert(errorMsg);
                    //location.reload();
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_acct_bal()
{
//var full_url = window.location.origin;

    
           $.ajax({
                url: full_url+'/controller/credit_controller.php',
                type: 'post',
                cache: false, 
                data:'type=load_acct_bal',
                async:true,

                success: function(data){
                    //alert(data);
                    
                    $('#balance_sec').empty();
                    $('#balance_sec').html(data);
                   
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    //alert(errorMsg);
                   // location.reload();
                    //$('#content').html(errorMsg);
                  }
            });
}
function load_login_users()
{
//var full_url = window.location.origin;

  //  alert('ok');
           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                data:'list_type=load_login_users',
                dataType:'json',
                async:true,
                cache: false, 
                success: function(data){
                    var username,logintime,profile_pic,hrs,mins,displaytime;
                    var login_record="";
                    var res = JSON.parse(JSON.stringify(data));
                    //console.log(res);
                    var len=res.length;

                      for(var i=0;i<len;i++)
                      {
                            displaytime="";
                            username=res[i]['user_name'];
                            logintime=res[i]['login_time'];
                            hrs=res[i]['hrs'];
                            mins=res[i]['minutes'];
                            if(hrs!=0)
                            {
                                displaytime=hrs+" hr ";
                            }

                            if(mins!=0)
                            {
                                displaytime+=mins+" mins ago";
                            }
                            else
                            {
                                displaytime+"ago";
                            }

                            if(hrs=='0' && mins=='0')
                            {
                                displaytime="Just Now";
                            }
                            
                            var dt=new Date(logintime);
                            profile_pic=res[i]['profile_pic'];
                            if(profile_pic==null || profile_pic=='')
                            {
                                profile_pic='profile_default.png';
                            }
                            login_record +="<div class='list-group-item'><a class='notification notification-flush notification-unread' href='#!'>"+
                            "<div class='notification-avatar'>"+
                              "<div class='avatar avatar-2xl me-3 status-online'>"+
                                "<div class='avatar-name rounded-circle'>"+
                                  "<img class='rounded-circle' src='assets/images/profile/"+profile_pic+"' alt='' />"+
                                "</div>"+
                              "</div>"+
                            "</div>"+
                            "<div class='notification-body'>"+
                              "<p class='mb-1'><strong>"+username+"</strong></p>"+
                              "<span class='notification-time'><span class='me-2 fab fa-gratipay text-danger'></span>"+displaytime+"</span>"+
                            "</div>"+
                          "</a>"+
                        "</div>";
                      }

                       $("#login_users").empty();
                      $("#login_users").append(login_record);
                   
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    //alert(errorMsg);
                    //location.reload();
                    //$('#content').html(errorMsg);
                  }
            });
}


// function dashboardchart(){
//     $.ajax({
//         url : 'controller/dashboard_controller.php',
//         type : 'post',
//         data : 'type=dashboardchart',
//         success : function(data){
//             $('#')
//         }
//     });
// }

/*function topusers(){
    $.ajax({
        url : 'controller/dashboard_controller.php',
        type : 'post',
        data : 'type=top_users',
        success : function(data){
            $('#top_users').html(data);
        },
        error : function (xhr, ajaxOptions, thrownError){
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            alert(data);
        }
    });
}

function userprofile(){

}*/

function searchData_smartcutoff() {
    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    //table.draw();
}