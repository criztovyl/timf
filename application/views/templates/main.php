<div id="header">
<?php
if(isset($header)){
	echo $header;
}
if(isset($headline)){
	echo "<h1>".$headline."</h1>";
}
?>
</div>
<!--Header End-->
<!--Main Part Start-->

<!--Mask Start-->
<div id="3cols" class="colmask threecol">

<!--ColMid Start-->
<div class="colmid">

<!--ColLeft Start-->
<div class="colleft">

<!-- Column 1(middle) Start -->
<div class="col1">
<?php
	include $main;
?>
</div>
<!-- Column 1 end -->

<!-- Column 2(left) start -->
<div class="col2">
<?php
	include $left;
?>
</div>
<!-- Column 2 end -->

<!-- Column 3(right) start -->
<div class="col3">
<?php
 include $right;
?>
</div>
<!--Column 3 End-->

</div>
<!--ColLeft End-->

</div>
<!--ColMid End-->

</div>
<!--Mask End-->
