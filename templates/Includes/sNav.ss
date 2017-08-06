<nav class="top center-block">
  <ul>
    <!-- <li class="current"><a href="#">Home</a></li>
    <li><a href="#">Page1</a></li>
    <li><a href="#">Page2</a></li> -->
    <% loop $Menu(1) %>
      <li class="$LinkingMode">
        <a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
      </li>
    <% end_loop %>
  </ul>
</nav>
