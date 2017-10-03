<% include sSubHeader %>

<section class="content">
  <div class="container">
    <h3>Survey Title: $Survey.Title</h3>
    <div id="ApiChart"></div>
    <div id="circleG" class="spinner">
      <div class="save-msg">Ajax request...</div>
      <div id="circleG_1" class="circleG"></div>
      <div id="circleG_2" class="circleG"></div>
      <div id="circleG_3" class="circleG"></div>
    </div>
  </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script>

$('#ApiChart').html( chartOnMobile(resultApi.d) )

function chartOnMobile(v) {
			var v_html="";
      console.log(v);
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
									tmp_v_html+="<td>"+(v.questions[i].options[o].title=="_"?("<i>Other</i>"):v.questions[i].options[o].title)+"</td>";
									tmp_v_html+="<td><div><div style='width:"+tmp_perc*100+"%; background: lightgreen; border-radius:0px 5px 5px 0px; float:left;'>&nbsp;</div></div></td>";
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
					v_html+="<div style='color: gray; text-align:right;'>Total answers: "+v.questions[i].total+"</div>";
					v_html+="</div>"
				}
			}
      return v_html;
		}

</script>
