<% include sSubHeader %>

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            User ID: $Member.ID
            <script>var userID = $Member.ID</script>
            <div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading"><span>Survey list</span>
                <button id="new-survey" class="btn btn-success">Add new Survey</button>
              </div>
              <!-- Table -->
              <table class="table">
                <!-- (tr>th{lorem2}*3)+(tr>lorem2*3)*3 -->
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Pin Code</th>
                  <th>Results</th>
                  <th>Edit</th>
                  <th>Del</th>
                </tr>

<% loop $Surveys %>
    <tr>
        <td>$ID</td>
        <td>$Title</td>
        <td>$Description</td>
        <td>$PIN</td>
        <td><a href="{$Up.Link}results/$ID" class="btn btn-info">Results</a></td>
        <td><a href="{$Up.Link}show/$ID" class="btn btn-primary">Edit</button></a></td>
        <td><button class="btn btn-danger del-survey" value="$ID">Delete</button></td>
    </tr>
<% end_loop %>
    <tr class="empty-item" style="display:none">
        <td></td>
        <td>New Survey</td>
        <td>...Description...</td>
        <td></td>
        <td><a href="" class="btn btn-info">Results</a></td>
        <td><a href="" class="btn btn-primary">Edit</button></a>
        <td><button class="btn btn-danger del-survey" value="">Delete</button></td>
    </tr>
              </table>
<!-- <div>TestFields: $GridField</div> -->
            </div>

          </div>
        </div>
      </div>
    </section>

      </div>
    </div>
  </div>
</section>
