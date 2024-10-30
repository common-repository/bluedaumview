<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>blueDaumView 설정</h2>
	<form action="options-general.php?page=<?php echo $this->pluginfile ?>" method="post">
	<table class="form-table">
		<tr>
			<th scope="row">추천 박스 모양:</th>
			<td>
				<fieldset><legend class="hidden">추천 박스 모양:</legend>
				<label title="recombox-type-1">
					<input name="recombox_type" value="1" <?php echo ($this->options['recombox_type'] == 1) ? 'checked="checked" ' : ''; ?>type="radio" /> 박스형<br />
					<img src="<?php echo $this->pluginurl?>/images/recombox_1.gif" />
				</label><br />
				<label title="recombox-type-2">
					<input name="recombox_type" value="2" <?php echo ($this->options['recombox_type'] == 2) ? 'checked="checked" ' : ''; ?>type="radio" /> 작은 박스형<br />
					<img src="<?php echo $this->pluginurl?>/images/recombox_2.gif" />
				</label><br />
				<label title="recombox-type-3">
					<input name="recombox_type" value="3" <?php echo ($this->options['recombox_type'] == 3) ? 'checked="checked" ' : ''; ?>type="radio" /> 버튼형<br />
					<img src="<?php echo $this->pluginurl?>/images/recombox_3.gif" />
				</label>
				</fieldset>
			</td>
		</tr>
		<tr>
			<th scope="row">추천 박스 출력 스킨:</th>
			<td>
				<fieldset><legend class="hidden">추천 박스 출력 스킨:</legend>
				<label title="recombox-skin">
					<textarea name="recombox_skin" style="width: 100%; height: 150px;"><?php echo htmlspecialchars(stripslashes($this->options['recombox_skin']))?></textarea>
				</label><br />
				</fieldset>
			</td>
		</tr>
	</table>
	<p class="submit"><input name="Submit" class="button-primary" value="Save Changes" type="submit"></p>
	</form>
</div>
