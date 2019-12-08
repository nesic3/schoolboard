<?php
	if(!defined("haug")){exit("Nothing here...");}

	#main::ppre($_req);
	/*
	if(isset($_req['student']) && !isset($_req['module'])){
		main::toUrl("students?student=$_req[student]&module=view");
	}
	*/

	$_students = students::fetch();
	#main::ppre($_students);
?>

<?php if(!$_students){ ?>
	<p><?php echo 'No students to show.'; ?></p>
<?php }else{ ?>
	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>School Board</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$rbr = 1;
			foreach($_students as $p){
		?>
			<tr>
				<td><?php echo "$rbr."; ?></td>
				<td><a href="?student=<?php echo $p['id']; ?>"><?php echo "$p[firstname] $p[surname]"; ?></a></td>
				<td align="right"><?php echo $p['schoolboard']; ?></td>
			</tr>
		<?php
				$rbr++;
			}
		?>
		</tbody>
	</table>
	<?php } ?>
