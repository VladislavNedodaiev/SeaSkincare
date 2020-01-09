<?php if (isset($businesses) && !empty($businesses)) { ?>

<nav class="navbar navbar-light bg-light justify-content-center">
<div class="pagination">
	<?php
	$per_page = 9;
	$count = count($businesses);
	if (isset($_GET['page']))
		$page = $_GET['page'];
	else
		$page = 0;
	$pages['current']=$page;
	if ($page > 0) {
		$pages['first']=0;
		if ($page > 1) {
			$pages['prev'] = $page - 1;
			
			if ($page > 2) {
				$pages['prevprev']='...';
			}
		}
	}
	if ($page < (int)($count / $per_page)) {
		$pages['last']=(int)($count / $per_page);
		if ($page < (int)($count / $per_page) - 1) {
			$pages['next'] = $page + 1;
			
			if ($page < (int)($count / $per_page) - 2) {
				$pages['nextnext']='...';
			}
		}
	}
		
	$varurl = '';
	if (isset($_GET)) {
		foreach ($_GET as $key => &$value) {
			if ($key != 'page')
				$varurl .= '&'.$key.'='.urlencode($value);
		}
	}
	?>
	
	<div class="page-item <?php if (!isset($pages['first'])) echo 'disabled'; ?>"><a class="page-link" <?php if (!isset($pages['first'])) echo 'tabindex="-1"'; ?> href="<?php if (isset($pages['first'])) { echo '?page='.$pages['prev'].$varurl; } else echo '#';?>">Попередня</a></div>
	<?php
	if (isset($pages['first']))
		echo '<div class="page-item"><a class="page-link" href="?page='.$pages['first'].$varurl.'">'.($pages['first'] + 1).'</a></div>';
	if (isset($pages['prevprev']))
		echo '<div class="page-item disabled"><a class="page-link" tabindex="-1">'.$pages['prevprev'].'</a></div>';
	if (isset($pages['prev']))
		echo '<div class="page-item"><a class="page-link" href="?page='.$pages['prev'].$varurl.'">'.($pages['prev'] + 1).'</a></div>';
	echo '<div class="page-item disabled"><a class="page-link" tabindex="-1" href="?page='.$pages['current'].$varurl.'">'.($pages['current'] + 1).'</a></div>';
	if (isset($pages['next']))
		echo '<div class="page-item"><a class="page-link" href="?page='.$pages['next'].$varurl.'">'.($pages['next'] + 1).'</a></div>';
	if (isset($pages['nextnext']))
		echo '<div class="page-item disabled"><a class="page-link" tabindex="-1">'.$pages['nextnext'].'</a></div>';
	if (isset($pages['last']))
		echo '<div class="page-item"><a class="page-link" href="?page='.$pages['last'].$varurl.'">'.($pages['last'] + 1).'</a></div>';
	?>
	<div class="page-item <?php if (!isset($pages['last'])) echo 'disabled'; ?>"><a class="page-link" <?php if (!isset($pages['last'])) echo 'tabindex="-1"'; ?> href="<?php if (isset($pages['last'])) { echo '?page='.$pages['next'].$varurl; } else echo '#';?>">Наступна</a></div>
</div>
</nav>

<?php } ?>
