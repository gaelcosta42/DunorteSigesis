<?php
  /**
   * Grupo
   *
   * @package Sigesis N1
   * @author Vale Telecom
   * @copyright 2022
   * @version 3
   */
  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');
  if (!$usuario->is_Todos())
	  redirect_to("login.php");
?>

#region Editar Grupo
<?php switch(Filter::$acao): case "editar": ?>
<?php $row = Core::getRowById("grupo", Filter::$id);?>
<div class="page-container">
	<div class="page-head">
		<div class="container">
			<div class="page-title">
				<h1><?php echo lang('GRUPO_TITULO');?>&nbsp;<i class="fa fa-angle-right"></i>&nbsp;<small><?php echo lang('GRUPO_EDITAR');?></small></h1>
			</div>
		</div>
	</div>
	<div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">		
					<div class="portlet box <?php echo $core->primeira_cor;?>">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit">&nbsp;&nbsp;</i><?php echo lang('GRUPO_EDITAR');?>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="" autocomplete="off" method="post" class="form-horizontal" name="admin_form" id="admin_form">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="row">

												<!-- nome -->
												<div class="form-group">
													<label class="control-label col-md-2"><?php echo lang('NOME');?></label>
													<div class="col-md-9">
														<input type="text" class="form-control caps" name="nome" value="<?php echo $row->grupo;?>">
													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-2"><?php echo lang('COR');?></label>
													<div class="col-md-9">
														<input type="text" id="cor" class="form-control" name="cor" 
															value="<?php echo $row->idcor; ?>"> 
														<div id="preview" 
															style="margin-top:10px; padding:10px; background:<?php echo $row->idcor; ?>; color:#fff; text-align:center; border-radius:6px;">
															<?php echo strtoupper($row->idcor); ?>
														</div>
														<canvas id="wheel" width="200" height="200" style="margin-top:15px; cursor:pointer; border-radius:50%;"></canvas>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>
								<input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
								<div class="form-actions">
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" class="btn <?php echo $core->primeira_cor;?>"><?php echo lang('SALVAR');?></button>
														<button type="button" id="voltar" class="btn default"><?php echo lang('VOLTAR');?></button>
													</div>
												</div>
											</div>
											<div class="col-md-6"></div>
										</div>
									</div>
								</div>
							</form>
							<?php echo $core->doForm("processarGrupo");?>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	#region Color Picker JS
	<?php if(Filter::$acao === "editar"): ?>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const canvas = document.getElementById("wheel");
			if (!canvas) return;
			const ctx = canvas.getContext("2d");
			const radius = canvas.width / 2;

			// desenha círculo cromático
			for (let angle = 0; angle < 360; angle++) {
				const start = (angle - 1) * Math.PI / 180;
				const end = angle * Math.PI / 180;
				ctx.beginPath();
				ctx.moveTo(radius, radius);
				ctx.arc(radius, radius, radius, start, end);
				ctx.closePath();
				ctx.fillStyle = "hsl(" + angle + ", 100%, 50%)";
				ctx.fill();
			}

			const input = document.getElementById("cor");
			const preview = document.getElementById("preview");

			// clique no círculo
			canvas.addEventListener("click", function(e) {
				const rect = canvas.getBoundingClientRect();
				const x = e.clientX - rect.left;
				const y = e.clientY - rect.top;
				const imgData = ctx.getImageData(x, y, 1, 1).data;

				const hex = "#" + [imgData[0], imgData[1], imgData[2]]
				.map(c => c.toString(16).padStart(2, "0"))
				.join("")
				.toUpperCase();

				input.value = hex;
				preview.style.background = hex;
				preview.textContent = hex;
			});

			// input manual
			input.addEventListener("input", function() {
				const val = this.value;
				if(/^#([0-9A-F]{3}){1,2}$/i.test(val)) {
				preview.style.background = val;
				preview.textContent = val.toUpperCase();
				}
			});

			// Ajuste para carregar a cor salva do banco no preview ao abrir a página
			if (input.value) {
				preview.style.background = input.value;
				preview.textContent = input.value.toUpperCase();
			}
		});
	</script>
	<?php endif; ?>
	#endregion Color Picker JS

<?php break;?>
#endregion Editar Grupo

#region Adicionar Grupo
<?php case "adicionar": ?>
<div class="page-container">
	<div class="page-head">
		<div class="container">
			<div class="page-title">
				<h1><?php echo lang('GRUPO_TITULO');?>&nbsp;<i class="fa fa-angle-right"></i>&nbsp;<small><?php echo lang('GRUPO_ADICIONAR');?></small></h1>
			</div>
		</div>
	</div>
	<div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">		
					<div class="portlet box <?php echo $core->primeira_cor;?>">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-plus-square">&nbsp;&nbsp;</i><?php echo lang('GRUPO_ADICIONAR');?>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="" autocomplete="off" method="post" class="form-horizontal" name="admin_form" id="admin_form">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="form-group">
													<label class="control-label col-md-2"><?php echo lang('NOME');?></label>
													<div class="col-md-9">
														<input type="text" class="form-control caps" name="nome">
													</div>
												</div>
												<!-- cor -->
												<div class="form-group">
                                        			<label class="control-label col-md-2"><?php echo lang('COR'); ?></label>
                                        			<div class="col-md-9">
														<div style="display:flex; flex-direction: row; gap:15px; align-items:center;">
															<!-- Canvas Color Wheel -->
															<canvas id="wheel" width="180" height="180" 
																style="border-radius:50%; cursor:crosshair; margin-top:20px;">
															</canvas>

															<!-- Input e Preview -->
															<div style="flex:1;">
																<input type="text" id="cor" name="cor" value="<?php echo $row->cor ?? '#FFFFFF'; ?>" 
																	style="width:150px; height:40px;" class="form-control caps">
																<div id="preview" 
																	style="margin-top:10px; height:35px; border-radius:6px; background:<?php echo $row->cor ?? '#FFFFFF'; ?>;
																	border:1px solid #ccc; display:flex; align-items:center; justify-content:center; font-weight:bold;">
																	<?php echo $row->cor ?? '#FFFFFF'; ?>
																</div>
                                                			</div>
                                            			</div>
                                        			</div>
                                    			</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" class="btn <?php echo $core->primeira_cor;?>"><?php echo lang('SALVAR');?></button>
														<button type="button" id="voltar" class="btn default"><?php echo lang('VOLTAR');?></button>
													</div>
												</div>
											</div>
											<div class="col-md-6"></div>
										</div>
									</div>
								</div>
							</form>
							<?php echo $core->doForm("processarGrupo");?>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	#region Color Picker JS
	<?php if(Filter::$acao === "adicionar"): ?>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const canvas = document.getElementById("wheel");
			if (!canvas) return;
			const ctx = canvas.getContext("2d");
			const radius = canvas.width / 2;

			// desenha círculo cromático
			for (let angle = 0; angle < 360; angle++) {
				const start = (angle - 1) * Math.PI / 180;
				const end = angle * Math.PI / 180;
				ctx.beginPath();
				ctx.moveTo(radius, radius);
				ctx.arc(radius, radius, radius, start, end);
				ctx.closePath();
				ctx.fillStyle = "hsl(" + angle + ", 100%, 50%)";
				ctx.fill();
			}

			const input = document.getElementById("cor");
			const preview = document.getElementById("preview");

			// clique no círculo
			canvas.addEventListener("click", function(e) {
				const rect = canvas.getBoundingClientRect();
				const x = e.clientX - rect.left;
				const y = e.clientY - rect.top;
				const imgData = ctx.getImageData(x, y, 1, 1).data;

				const hex = "#" + [imgData[0], imgData[1], imgData[2]]
				.map(c => c.toString(16).padStart(2, "0"))
				.join("")
				.toUpperCase();

				input.value = hex;
				preview.style.background = hex;
				preview.textContent = hex;
			});

			// input manual
			input.addEventListener("input", function() {
				const val = this.value;
				if(/^#([0-9A-F]{3}){1,2}$/i.test(val)) {
				preview.style.background = val;
				preview.textContent = val.toUpperCase();
				}
			});
		});
	</script>
	<?php endif; ?>
	#endregion Color Picker JS

<?php break;?>
#endregion Adicionar Grupo

#region Listar Grupo
<?php case "listar": ?>
<div class="page-container">
	<div class="page-head">
		<div class="container">
			<div class="page-title">
				<h1><?php echo lang('GRUPO_TITULO');?>&nbsp;<i class="fa fa-angle-right"></i>&nbsp;<small><?php echo lang('GRUPO_LISTAR');?></small></h1>
			</div>
		</div>
	</div>
	<div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">						
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list font-<?php echo $core->primeira_cor;?>"></i>								
								<span class="font-<?php echo $core->primeira_cor;?>"><?php echo lang('GRUPO_LISTAR');?></span>
							</div>
							<div class="actions btn-set">
								<a href="index.php?do=grupo&acao=adicionar" class="btn btn-sm <?php echo $core->primeira_cor;?>"><i class="fa fa-plus-square">&nbsp;&nbsp;</i><?php echo lang('ADICIONAR');?></a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-bordered table-striped table-condensed table-advance dataTable">
								<thead>
									<tr>
										<th><?php echo lang('NOME');?></th>
                                        <th><?php echo lang('OPCOES');?></th>
									</tr>
								</thead>
								<tbody>
								<?php 	
										$retorno_row = $grupo->getGrupos();
										if($retorno_row):
										foreach ($retorno_row as $exrow):?>
									<tr>
										<td><a href="index.php?do=grupo&acao=editar&id=<?php echo $exrow->id;?>"><?php echo $exrow->grupo;?></a></td>
										<td>
											<a href="index.php?do=grupo&acao=editar&id=<?php echo $exrow->id;?>" class="btn btn-sm blue" title="<?php echo lang('EDITAR').': '.$exrow->grupo;?>"><i class="fa fa-pencil"></i></a>
											<a href="javascript:void(0);" class="btn btn-sm red apagar" id="<?php echo $exrow->id;?>" acao="apagarGrupo" title="<?php echo lang('GRUPO_APAGAR').$exrow->grupo;?>"><i class="fa fa-times"></i></a>
										</td>
									</tr>
								<?php endforeach; endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php break;?>
#end

<?php default: ?>
<div class="imagem-fundo">
	<img src="assets/img/logo.png" border="0">
</div>
<?php break;?>
<?php endswitch;?>
