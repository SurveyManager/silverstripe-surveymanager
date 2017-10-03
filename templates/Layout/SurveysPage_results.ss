<% include sSubHeader %>

<section class="content">
  <div class="container">
    Survey: $Survey.Title
    <div id="resultChart">CHART</div>
    <div id="circleG" class="spinner">
      <div class="save-msg">Ajax request...</div>
      <div id="circleG_1" class="circleG"></div>
      <div id="circleG_2" class="circleG"></div>
      <div id="circleG_3" class="circleG"></div>
    </div>
  </div>
</section>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>

Highcharts.chart('resultChart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Title: $Survey.Title'
    },
    subtitle: {
        text: 'Description: $Survey.Description'
    },
    xAxis: {
        categories: [
            'Quest1',
            'Quest2',
            'Quest3',
            'Quest4',
            'Quest5',
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'yAxis Text Title'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Answer1',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6]

    }, {
        name: 'Answer2',
        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

    }, {
        name: 'Answer3',
        data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

    }, {
        name: 'Answer4',
        data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

    }]
});
///////////////////////////////


//////////////////////////////////

function chartOnMobile(v) {
		//console.warn("Results",v);
		// if (this.getSurveyCallback) {
		// 	this.surveyTXTresult=false;
			//var v_js = JSON.stringify(v.questions).replace(new RegExp("\}","g"),"} \n");
			var v_html="";
			for (var i in v.questions) {
				if (v.questions[i].title) {
					v_html+="<div style='margin:15px 0px 5px 0px; padding:15px 5px 0px 5px; border-top:1px solid gray;'>";
					v_html+="<div style='text-weight: bold;'>"+v.questions[i].title+"</div>";
					v_html+="<div style='color: gray; margin-bottom:5px;'>"+v.questions[i].description+"</div>";
					if (v.questions[i].type=='one' || v.questions[i].type=='multi') {
						var get_max=0;
						var get_sum=0;
						for (var o in v.questions[i].options) {
							if (v.questions[i].options[o] && (o>0 || v.questions[i].other==1)) {
								if (get_max<v.questions[i].options[o].results) get_max=v.questions[i].options[o].results;
								get_sum+=parseInt(v.questions[i].options[o].results);
							}
						}
						var tmp_v_html_after="";
						var tmp_v_html="";
						v_html+="<table><thead><tr><th width=40%></th><th></th><th width=1%></th></tr></thead><tbody>";
						for (var o in v.questions[i].options) {
							if (v.questions[i].options[o] && (o>0 || v.questions[i].other==1)) {
								if (get_max==0)  {
									var tmp_perc=0;
								} else {
									var tmp_perc=v.questions[i].options[o].results/get_max;
								}
								tmp_v_html="<tr>";
									tmp_v_html+="<td>"+(v.questions[i].options[o].title=="_"?("<i>"+l18n.othershort+"</i>"):v.questions[i].options[o].title)+"</td>";
									tmp_v_html+="<td><div><div style='width:"+tmp_perc*100+"%; background: "+Color.LightGreen+"; border-radius:0px 5px 5px 0px; float:left;'>&nbsp;</div></div></td>";
									if (get_sum>0) {
										tmp_v_html+="<td nowrap style='text-align:right;'>"+(Math.round((v.questions[i].options[o].results/get_sum)*1000)/10)+"%</td>";
									} else {
										tmp_v_html+="<td>&nbsp;</td>";
									}
								tmp_v_html+="</tr>";
								if (o==0) {
									tmp_v_html_after=tmp_v_html;
								} else {
									v_html+=tmp_v_html;
								}
							}
						}
						v_html+=tmp_v_html_after+"</tbody></table>"
					}
					v_html+="<div style='color: gray; text-align:right;'>"+l18n.totalanswers+": "+v.questions[i].total+"</div>";
					v_html+="</div>"
				}
			}
			//console.log(this.surveyTXTresult);
			// v_html="<html><body style='margin:0; padding:0;'><div style='width:100%; margin-bottom:25px;'>"+v_html+"</div></body></html>";
			// this.getSurveyCallback({ title: v.survey.title, description: v.survey.Description}, "", v_html);
		}
	// }


</script>
