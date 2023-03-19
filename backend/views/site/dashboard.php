<div class="dashboard-index">
	<div class="jumbotron text-center bg-transparent">
		<h3>Number and % of peniaga registered by PBT</h3>
		<hr/>
		<table class="table table-sm table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">PBT</th>
					<th scope="col">Jumlah Peniaga</th>
					<th scope="col">Jumlah Berdaftar</th>
					<th scope="col">% berdaftar</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($analysisModels as $key=>$model):?>
					<tr>
						<th scope="row"><?= ++$key?></th>
						<td><?= $model['pbt_location_code']?></td>
						<td><?= $model['jumlah_peniaga']?></td>
						<td><?= $model['jumlah_berdaftar']?></td>
						<td><?= number_format($model['jumlah_berdaftar']/$model['jumlah_peniaga'],4)?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
		<br/>

		<h3>Number of website visits</h3>
		<hr/>
		<table class="table table-sm table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Type</th>
					<th scope="col">Path</th>
					<th scope="col">Total Views</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($pageModels as $key=>$model):?>
					<tr>
						<th scope="row"><?= ++$key?></th>
						<td><?= $model['type']?></td>
						<td><?= $model['name']?></td>
						<td><?= $model['total_views']?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>

		<h3>Number of times Whatsapp order button is cliecked</h3>
		<hr/>
		<table class="table table-sm table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">PBT</th>
					<th scope="col">Total Order</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($whatsappModels as $key=>$model):?>
					<tr>
						<th scope="row"><?= ++$key?></th>
						<td><?= $model['pbt_location_code']?></td>
						<td><?= $model['total_order']?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>

		<h3>Top 20 peniaga with the most clicked Whatsapp order button</h3>
		<hr/>
		<table class="table table-sm table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">PBT</th>
					<th scope="col">Bazar</th>
					<th scope="col">Total Order</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($top20Models as $key=>$model):?>
					<tr>
						<th scope="row"><?= ++$key?></th>
						<td><?= $model['pbt_location_code']?></td>
						<td><?= $model['shop_name']?></td>
						<td><?= $model['total_order']?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>