<?php
	if(!defined("haug")){exit("Nothing here...");}

	#main::ppre($_req);
	if(isset($_req['student']) && !isset($_req['module'])){
		main::toUrl("students?student=$_req[student]&module=view");
	}

	$_students = students::fetch();
	#main::ppre($_students);
?>
<div class="section values">
	<div class="container">
		<div class="row">
			<div class="twelve columns">
			<?php if(!$_students){ ?>
				<p><?php echo 'No students to show.'; ?></p>
			<?php }else{ ?>
				<table class="u-full-width">
					<thead>
						<tr>
							<th>Name</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach($_students as $p){
					?>
						<tr>
							<td><?php echo "$p[firstname] $p[surname]"; ?></td>
							<td>
								<a href="students?id=<?php echo $p['id']; ?>&module=view">View</a>
								<a href="students?id=<?php echo $p['id']; ?>&module=edit">Edit</a>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
