<?php
$totalRowCount = $totalRowCount ? $totalRowCount : 0;
$from = $index + 1;
$to = ($from + $limit) - 1;
if ($to > $totalRowCount) {
	$to = $totalRowCount;
}

require_once('header.php');
?>
<?php if ($totalRowCount > 0) : ?>
	<div class="show_count"><span class="numberCircle"> <?php echo $totalRowCount; ?></span> 件中 <span class="numberCircle"> <?php echo $from; ?></span> ~ <span class="numberCircle"> <?php echo $to; ?></span></div>
<?php endif; ?>
<br>

<?php
$range = MAX_PAGE_COUNT;

if ($totalPages > $range) {
	if ($page > 1) {
		$prevPage = $page - 1;
		echo " <a href='index.php?" . withoutPageParamUrl() . "page=$prevPage'>前へ</a> ";
	}

	if ($page + $range - 1 <= $totalPages) {
		for ($index = $page; $index < (($page + $range)); $index++) {
			if ($index == $page) {
				echo " <b>$index</b> ";
			} else {
				echo " <a href='index.php?" . withoutPageParamUrl() . "page=$index'>$index</a> ";
			}
		}
	} else {
		for ($index = $totalPages - $range + 1; $index < $totalPages + 1; $index++) {
			if ($index == $page) {
				echo " <b>$index</b> ";
			} else {
				echo " <a href='index.php?" . withoutPageParamUrl() . "page=$index'>$index</a> ";
			}
		}
	}
	if (($page + $range - 1) < $totalPages) {
		$nextPage = $page + 1;
		echo " <a href='index.php?" . withoutPageParamUrl() . "page=$nextPage'>次へ</a> ";
	}
} else {
	for ($index = 1; $index <= $totalPages; $index++) {
		if ($index == $page) {
			echo " <b>$index</b> ";
		} else {
			echo " <a href='index.php?" . withoutPageParamUrl() . "page=$index'>$index</a> ";
		}
	}
}

require_once('footer.php');
?>