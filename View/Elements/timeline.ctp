<?php
// Assemble links for this timeline.
$link = '/'.$selectedTab.'/index/'.$accountId.'/';

// Get the correct link in relation to the cake root.
$link = Router::url($link);

// Assemble needed links.
$lastYear = $link.($year - 1).'12';
$nextYear = $link.($year + 1).'01';
$currentYear = $link.$year;
?>
<div id="timeline">
  <div id="year_selector">
    <ul class="nav">
      <li class="nav"><a href="<?php echo $lastYear; ?>" onclick="go('<?php echo $lastYear; ?>');return false;">&lt;</a></li>
      <li class="nav selected"><?php echo $year; ?></li>
      <li class="nav"><a href="<?php echo $nextYear; ?>" onclick="go('<?php echo $nextYear; ?>');return false;">&gt;</a></li>
    </ul>
  </div>
  <div id="month_selector">
    <ul class="nav">
    <?php for($m = 1; $m <= 12; $m++):?>
      <li class="nav<?php if($m == $month) echo ' selected'; ?>">
<?php
if($m != $month)
{
  $currentMonth = sprintf("%s%02d",$currentYear,$m);
?>
        <a href="<?php echo $currentMonth; ?>" onclick="go('<?php echo $currentMonth; ?>');return false;">
<?php
}
?>
        <?php echo __(date_format(date_create($m.'/01/'.$year),'M')); ?>
<?php
if($m != $month)
{
?>
        </a>
<?php
}
?>
      </li>
    <?php endfor; ?>
    </ul>
  </div>
</div>
