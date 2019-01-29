<div>
	<div class="endereco">
		<p>
		<label for="enderecoUF">UF:</label> <br />
		<select id="enderecoUF" name="endereco-estado" >
			<option value="AC" <?php echo ($endereco['uf'] == "AC" ? "selected='selected'" : ""); ?>>AC</option>
			<option value="AL" <?php echo ($endereco['uf'] == "AL" ? "selected='selected'" : ""); ?>>AL</option>
			<option value="AM" <?php echo ($endereco['uf'] == "AM" ? "selected='selected'" : ""); ?>>AM</option>
			<option value="AP" <?php echo ($endereco['uf'] == "AP" ? "selected='selected'" : ""); ?>>AP</option>
			<option value="BA" <?php echo ($endereco['uf'] == "BA" ? "selected='selected'" : ""); ?>>BA</option>
			<option value="CE" <?php echo ($endereco['uf'] == "CE" ? "selected='selected'" : ""); ?>>CE</option>
			<option value="DF" <?php echo ($endereco['uf'] == "DF" ? "selected='selected'" : ""); ?>>DF</option>
			<option value="ES" <?php echo ($endereco['uf'] == "ES" ? "selected='selected'" : ""); ?>>ES</option>
			<option value="GO" <?php echo ($endereco['uf'] == "GO" ? "selected='selected'" : ""); ?>>GO</option>
			<option value="MA" <?php echo ($endereco['uf'] == "MA" ? "selected='selected'" : ""); ?>>MA</option>
			<option value="MG" <?php echo ($endereco['uf'] == "MG" ? "selected='selected'" : ""); ?>>MG</option>
			<option value="MS" <?php echo ($endereco['uf'] == "MS" ? "selected='selected'" : ""); ?>>MS</option>
			<option value="MT" <?php echo ($endereco['uf'] == "MT" ? "selected='selected'" : ""); ?>>MT</option>
			<option value="PA" <?php echo ($endereco['uf'] == "PA" ? "selected='selected'" : ""); ?>>PA</option>
			<option value="PB" <?php echo ($endereco['uf'] == "PB" ? "selected='selected'" : ""); ?>>PB</option>
			<option value="PE" <?php echo ($endereco['uf'] == "PE" ? "selected='selected'" : ""); ?>>PE</option>
			<option value="PI" <?php echo ($endereco['uf'] == "PI" ? "selected='selected'" : ""); ?>>PI</option>
			<option value="PR" <?php echo ($endereco['uf'] == "PR" ? "selected='selected'" : ""); ?>>PR</option>
			<option value="RJ" <?php echo ($endereco['uf'] == "RJ" ? "selected='selected'" : ""); ?>>RJ</option>
			<option value="RN" <?php echo ($endereco['uf'] == "RN" ? "selected='selected'" : ""); ?>>RN</option>
			<option value="RS" <?php echo ($endereco['uf'] == "RS" ? "selected='selected'" : ""); ?>>RS</option>
			<option value="RO" <?php echo ($endereco['uf'] == "RO" ? "selected='selected'" : ""); ?>>RO</option>
			<option value="RR" <?php echo ($endereco['uf'] == "RR" ? "selected='selected'" : ""); ?>>RR</option>
			<option value="SC" <?php echo ($endereco['uf'] == "SC" ? "selected='selected'" : ""); ?>>SC</option>
			<option value="SE" <?php echo ($endereco['uf'] == "SE" ? "selected='selected'" : ""); ?>>SE</option>
			<option value="SP" <?php echo ($endereco['uf'] == "SP" ? "selected='selected'" : ""); ?>>SP</option>
			<option value="TO" <?php echo ($endereco['uf'] == "TO" ? "selected='selected'" : ""); ?>>TO</option>
 		</select>
		</p><p>
		 <label for="enderecoCidade">Cidade:</label> <br />
		<input type="text" name="endereco[cidade]" 		id="enderecoCidade" 	style="width: 80%" value="<?php echo $endereco['cidade']; ?>" />
		</p><p>
		<label for="enderecoRua">Endereço:</label> <br />
		<input type="text" name="endereco[endereco]" 	id="enderecoRua" 			style="width: 80%" value="<?php echo $endereco['endereco']; ?>" />
		</p><p>
		<label for="enderecoTelefone">Telefone:</label> <br />
		<input type="text" name="endereco[telefone]" 	id="enderecoTelefone" style="width: 80%" value="<?php echo $endereco['telefone']; ?>" />
		</p><p>
		<label for="enderecoEmail">e-mail:</label> <br />
		<input type="text" name="endereco[email]" 		id="enderecoEmail" 		style="width: 80%" value="<?php echo $endereco['email']; ?>" />
		</p>
	</div>
</div>